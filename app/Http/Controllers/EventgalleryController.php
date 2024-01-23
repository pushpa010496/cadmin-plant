<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventGallery;
use Illuminate\Http\Request;
use \Session;

class EventGalleryController extends Controller
{
	protected $model;

	public function __construct(EventGallery $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventgallery = EventGallery::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('title', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventgallery = EventGallery::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventGallery::where('active_flag', 1);
		return view('eventgallery.index', compact('eventgallery', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventgallery.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventgallery = new EventGallery();

		request()->validate([
			'title' => 'required',
            'small_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'big_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('small_img')){
        $small_imgName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_img')->getClientOriginalName());
        request()->small_img->move(public_path('event/gallery'), $small_imgName);
		$eventgallery->small_img = $small_imgName;	
	    }
	    if($request->file('big_img')){
        $big_imgName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_img')->getClientOriginalName());
        request()->big_img->move(public_path('event/gallery'), $big_imgName);
		$eventgallery->big_img = $big_imgName;	
	    }
	   	
	  	$eventgallery->event_id = $request->input("event_id");
	   	$eventgallery->title = $request->input("title");
	  	
	  	$eventgallery->img_title = ucfirst($request->input("img_title"));
	   	$eventgallery->img_alt = ucfirst($request->input("img_alt"));
	
		$eventgallery->active_flag = $request->input("active_flag");
		$eventgallery->author_id = $request->user()->id;

		$eventgallery->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventgallery->title . " was Created.");

		return redirect()->route('eventgallery.index');
	}

	public function show(EventGallery $eventgallery)
	{
		//$eventgallery = $this->model->findOrFail($id);

		return view('eventgallery.show', compact('eventgallery'));
	}
	public function edit(EventGallery $eventgallery)
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

		return view('eventgallery.edit', compact('eventgallery','eventlist'));
	}

	public function update(Request $request, eventgallery $eventgallery, User $user)
	{
		request()->validate([
			'title' => 'required',
            'small_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'big_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('event/gallery');
		if($request->file('small_img')){  
		$small_imgName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_img')->getClientOriginalName());
			if(request()->small_img->move($path, $small_imgName)){
				if(\File::exists($path.'/'.$eventgallery->small_img)){	        		
					\File::delete($path.'/'.$eventgallery->small_img);        	        		
				}        	
			}
			$eventgallery->small_img = $small_imgName;	
	    }
	    if($request->file('big_img')){      	
		 $big_imgName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_img')->getClientOriginalName());
			if(request()->big_img->move($path, $big_imgName)){
				if(\File::exists($path.'/'.$eventgallery->big_img)){	        		
					\File::delete($path.'/'.$eventgallery->big_img);        	        		
				}        	
			}
			$eventgallery->big_img = $big_imgName;	
	    }
	   	
	  	$eventgallery->event_id = $request->input("event_id");
	   	$eventgallery->title = $request->input("title");
	  	
	  	$eventgallery->img_title = ucfirst($request->input("img_title"));
	   	$eventgallery->img_alt = ucfirst($request->input("img_alt"));
	
		$eventgallery->active_flag = $request->input("active_flag");
		$eventgallery->author_id = $request->user()->id;

		$eventgallery->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventgallery->title . " was Updated.");

		return redirect()->route('eventgallery.index');
	}
	public function destroy(EventGallery $eventgallery)
	{
		$eventgallery->active_flag = 0;
		$eventgallery->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventgallery->title . ' was De-Activated.');

		return redirect()->route('eventgallery.index');
	}

	public function reactivate(EventGallery $eventgallery,$id)
	{

		$eventgallery = EventGallery::findOrFail($id);
		$eventgallery->active_flag = 1;
		$eventgallery->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventgallery->title . ' was Re-Activated.');

		return redirect()->route('eventgallery.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventGallery::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("og_title");
		$meta->og_description = $request->input("og_description");
		$meta->og_keywords = $request->input("og_keywords");
		$meta->og_image = $request->input("og_image");
		$meta->og_video = $request->input("og_video");
		$meta->meta_region = $request->input("meta_region");
		$meta->meta_position = $request->input("meta_position");
		$meta->meta_icbm = $request->input("meta_icbm");
		$meta->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'Event Gallery ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventgallery.index');
	}
}

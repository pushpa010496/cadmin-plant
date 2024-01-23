<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventSpeaker;
use Illuminate\Http\Request;
use \Session;

class EventSpeakerController extends Controller
{
	protected $model;

	public function __construct(EventSpeaker $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventspeakers = EventSpeaker::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventspeakers = EventSpeaker::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventSpeaker::where('active_flag', 1);
		return view('eventspeakers.index', compact('eventspeakers', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventspeakers.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventspeaker = new EventSpeaker();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'speaker_profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/speaker'), $imageName);
		$eventspeaker->image = $imageName;	
	    }
	    if($request->file('speaker_profile_img')){
        $speaker_profile_imgName = preg_replace('/\s+/','-',time().'-'.$request->file('speaker_profile_img')->getClientOriginalName());
        request()->speaker_profile_img->move(public_path('event/speaker'), $speaker_profile_imgName);
		$eventspeaker->speaker_profile_img = $speaker_profile_imgName;	
	    }
	   	
	  	$eventspeaker->event_id = $request->input("event_id");
	   	$eventspeaker->name = $request->input("name");
	  	
	  	$eventspeaker->img_title = ucfirst($request->input("img_title"));
	   	$eventspeaker->img_alt = ucfirst($request->input("img_alt"));
	   	$eventspeaker->designation = ucfirst($request->input("designation"));
	   	$eventspeaker->type = $request->input("type");
	   	$eventspeaker->show_on_profile = $request->input("show_on_profile");
	
		$eventspeaker->active_flag = $request->input("active_flag");
		$eventspeaker->author_id = $request->user()->id;

		$eventspeaker->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventspeaker->name . " was Created.");

		return redirect()->route('eventspeakers.index');
	}

	public function show(EventSpeaker $eventspeaker)
	{
		//$eventspeaker = $this->model->findOrFail($id);

		return view('eventspeakers.show', compact('eventspeaker'));
	}
	public function edit(EventSpeaker $eventspeaker)
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

		return view('eventspeakers.edit', compact('eventspeaker','eventlist'));
	}

	public function update(Request $request, EventSpeaker $eventspeaker, User $user)
	{
		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'speaker_profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('event/speaker');
		if($request->file('image')){
		$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){
				if(\File::exists($path.'/'.$eventspeaker->image)){	        		
					\File::delete($path.'/'.$eventspeaker->image);        	        		
				}        	
			}
			$eventspeaker->image = $imageName;	
	    }
	    if($request->file('speaker_profile_img')){       
		$speaker_profile_imgName = preg_replace('/\s+/','-',time().'-'.$request->file('speaker_profile_img')->getClientOriginalName());
			if(request()->speaker_profile_img->move($path, $speaker_profile_imgName)){
				if(\File::exists($path.'/'.$eventspeaker->speaker_profile_img)){	        		
					\File::delete($path.'/'.$eventspeaker->speaker_profile_img);        	        		
				}        	
			}
			$eventspeaker->speaker_profile_img = $speaker_profile_imgName;	
	    }
	   	
	  	$eventspeaker->event_id = $request->input("event_id");
	   	$eventspeaker->name = $request->input("name");
	  	
	  	$eventspeaker->img_title = ucfirst($request->input("img_title"));
	   	$eventspeaker->img_alt = ucfirst($request->input("img_alt"));
	   	$eventspeaker->designation = ucfirst($request->input("designation"));
	   	$eventspeaker->type = $request->input("type");
	   	$eventspeaker->show_on_profile = $request->input("show_on_profile");
	
		$eventspeaker->active_flag = $request->input("active_flag");
		$eventspeaker->author_id = $request->user()->id;

		$eventspeaker->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventspeaker->name . " was Updated.");

		return redirect()->route('eventspeakers.index');
	}
	public function destroy(EventSpeaker $eventspeaker)
	{
		$eventspeaker->active_flag = 0;
		$eventspeaker->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventspeaker->name . ' was De-Activated.');

		return redirect()->route('eventspeakers.index');
	}

	public function reactivate(EventSpeaker $eventspeaker,$id)
	{

		$eventspeaker = EventSpeaker::findOrFail($id);
		$eventspeaker->active_flag = 1;
		$eventspeaker->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventspeaker->name . ' was Re-Activated.');

		return redirect()->route('eventspeakers.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventSpeaker::findOrFail($id);
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
		Session::flash('message', 'Event Speaker ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventspeakers.index');
	}
}

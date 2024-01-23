<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventPressrealese;
use Illuminate\Http\Request;
use \Session;

class EventPressrealeseController extends Controller
{
	protected $model;

	public function __construct(EventPressrealese $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventpressrealese = EventPressrealese::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventpressrealese = EventPressrealese::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventPressrealese::where('active_flag', 1);
		return view('eventpressrealese.index', compact('eventpressrealese', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventpressrealese.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventpressrealese = new EventPressrealese();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/pressrealese'), $imageName);
		$eventpressrealese->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/pressrealese'), $pdfName);
		$eventpressrealese->pdf = $pdfName;	
	    }
	   	
	  	$eventpressrealese->event_id = $request->input("event_id");
	   	$eventpressrealese->name = $request->input("name");
	  	
	  	$eventpressrealese->img_title = ucfirst($request->input("img_title"));
	   	$eventpressrealese->img_alt = ucfirst($request->input("img_alt"));
	   	$eventpressrealese->description = ucfirst($request->input("description"));	
		$eventpressrealese->active_flag = $request->input("active_flag");
		$eventpressrealese->author_id = $request->user()->id;

		$eventpressrealese->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventpressrealese->name . " was Created.");

		return redirect()->route('eventpressrealese.index');
	}

	public function show(EventPressrealese $eventpressrealese)
	{
		//$eventpressrealese = $this->model->findOrFail($id);

		return view('eventpressrealese.show', compact('eventpressrealese'));
	}
	public function edit(EventPressrealese $eventpressrealese)
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

		return view('eventpressrealese.edit', compact('eventpressrealese','eventlist'));
	}

	public function update(Request $request, EventPressrealese $eventpressrealese, User $user){

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('event/pressrealese');
		if($request->file('image')){        
			$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){
				if(\File::exists($path.'/'.$eventpressrealese->image)){	        		
					\File::delete($path.'/'.$eventpressrealese->image);        	        		
				}        	
			}
			$eventpressrealese->image = $imageName;	
		}
	    if($request->file('pdf')){      
		  $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
			if(request()->pdf->move($path, $pdfName)){
				if(\File::exists($path.'/'.$eventpressrealese->pdf)){	        		
					\File::delete($path.'/'.$eventpressrealese->pdf);        	        		
				}        	
			}
			$eventpressrealese->pdf = $pdfName;	
	    }
	   	
	  	$eventpressrealese->event_id = $request->input("event_id");
	   	$eventpressrealese->name = $request->input("name");
	  	
	  	$eventpressrealese->img_title = ucfirst($request->input("img_title"));
	   	$eventpressrealese->img_alt = ucfirst($request->input("img_alt"));
	   	$eventpressrealese->description = ucfirst($request->input("description"));	
		$eventpressrealese->active_flag = $request->input("active_flag");
		$eventpressrealese->author_id = $request->user()->id;

		$eventpressrealese->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventpressrealese->name . " was Updated.");

		return redirect()->route('eventpressrealese.index');
	}
	public function destroy(EventPressrealese $eventpressrealese)
	{
		$eventpressrealese->active_flag = 0;
		$eventpressrealese->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventpressrealese->name . ' was De-Activated.');

		return redirect()->route('eventpressrealese.index');
	}

	public function reactivate(EventPressrealese $eventpressrealese,$id)
	{

		$eventpressrealese = EventPressrealese::findOrFail($id);
		$eventpressrealese->active_flag = 1;
		$eventpressrealese->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventpressrealese->name . ' was Re-Activated.');

		return redirect()->route('eventpressrealese.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventPressrealese::findOrFail($id);
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
		Session::flash('message', 'Event Pressrealese ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventpressrealese.index');
	}
}

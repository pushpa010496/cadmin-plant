<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventBrochure;
use Illuminate\Http\Request;
use \Session;

class EventBrochureController extends Controller
{
	protected $model;

	public function __construct(EventBrochure $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventbrochures = EventBrochure::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$eventbrochures = EventBrochure::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventBrochure::where('active_flag', 1);
		return view('eventbrochure.index', compact('eventbrochures', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventbrochure.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventbrochure = new EventBrochure();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/brochure'), $imageName);
		$eventbrochure->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/brochure'), $pdfName);
		$eventbrochure->pdf = $pdfName;	
	    }
	   	
	  	$eventbrochure->event_id = $request->input("event_id");
	   	$eventbrochure->name = $request->input("name");
	  	
	  	$eventbrochure->img_title = ucfirst($request->input("img_title"));
	   	$eventbrochure->img_alt = ucfirst($request->input("img_alt"));
		$eventbrochure->active_flag = $request->input("active_flag");
		$eventbrochure->author_id = $request->user()->id;

		$eventbrochure->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventbrochure->name . " was Created.");

		return redirect()->route('eventbrochures.index');
	}

	public function show(EventBrochure $eventbrochure)
	{
		//$eventbrochure = $this->model->findOrFail($id);

		return view('eventbrochure.show', compact('eventbrochure'));
	}
	public function edit(EventBrochure $eventbrochure)
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');
		return view('eventbrochure.edit', compact('eventbrochure','eventlist'));
	}

	public function update(Request $request, EventBrochure $eventbrochure, User $user){

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('event/brochure');
		if($request->file('image')){
		$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());        
			if(request()->image->move($path, $imageName)){
				if(\File::exists($path.'/'.$eventbrochure->image)){	        		
					\File::delete($path.'/'.$eventbrochure->image);        	        		
				}        	
			}
			$eventbrochure->image = $imageName;	
	    }
	    if($request->file('pdf')){
			$pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());        
			if(request()->pdf->move($path, $pdfName)){
				if(\File::exists($path.'/'.$eventbrochure->pdf)){	        		
					\File::delete($path.'/'.$eventbrochure->pdf);        	        		
				}        	
			}
			$eventbrochure->pdf = $pdfName;	
	    }
	   	
	  	$eventbrochure->event_id = $request->input("event_id");
	   	$eventbrochure->name = $request->input("name");
	  	
	  	$eventbrochure->img_title = ucfirst($request->input("img_title"));
	   	$eventbrochure->img_alt = ucfirst($request->input("img_alt"));
		$eventbrochure->active_flag = $request->input("active_flag");
		$eventbrochure->author_id = $request->user()->id;

		$eventbrochure->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventbrochure->name . " was Updated.");

		return redirect()->route('eventbrochures.index');
	}
	public function destroy(EventBrochure $eventbrochure)
	{
		$eventbrochure->active_flag = 0;
		$eventbrochure->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventbrochure->name . ' was De-Activated.');

		return redirect()->route('eventbrochures.index');
	}

	public function reactivate(EventBrochure $eventbrochure,$id)
	{

		$eventbrochure = EventBrochure::findOrFail($id);
		$eventbrochure->active_flag = 1;
		$eventbrochure->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventbrochure->name . ' was Re-Activated.');

		return redirect()->route('eventbrochures.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventBrochure::findOrFail($id);
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
		Session::flash('message', 'Event Brochure ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventbrochures.index');
	}
}

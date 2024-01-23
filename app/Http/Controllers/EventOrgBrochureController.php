<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\EventOrg;
use App\EventOrgBrochure;
use Illuminate\Http\Request;
use \Session;

class EventOrgBrochureController extends Controller
{
	protected $model;

	public function __construct(EventOrgBrochure $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventorgbrochures = EventOrgBrochure::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$eventorgbrochures = EventOrgBrochure::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventOrgBrochure::where('active_flag', 1);
		return view('eventorgbrochure.index', compact('eventorgbrochures', 'active'));
    }

	public function create()
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');
	    return view('eventorgbrochure.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventorgbrochure = new EventOrgBrochure();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/brochure'), $imageName);
		$eventorgbrochure->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/brochure'), $pdfName);
		$eventorgbrochure->pdf = $pdfName;	
	    }
	   	
	  	$eventorgbrochure->event_org_id = $request->input("event_org_id");
	   	$eventorgbrochure->name = $request->input("name");
	  	
	  	$eventorgbrochure->img_title = ucfirst($request->input("img_title"));
	   	$eventorgbrochure->img_alt = ucfirst($request->input("img_alt"));
		$eventorgbrochure->active_flag = $request->input("active_flag");
		$eventorgbrochure->author_id = $request->user()->id;

		$eventorgbrochure->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgbrochure->name . " was Created.");

		return redirect()->route('eventorgbrochures.index');
	}

	public function show(EventOrgBrochure $eventorgbrochure)
	{
		//$eventorgbrochure = $this->model->findOrFail($id);

		return view('eventorgbrochure.show', compact('eventorgbrochure'));
	}
	public function edit(EventOrgBrochure $eventorgbrochure)
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');
		return view('eventorgbrochure.edit', compact('eventorgbrochure','eventlist'));
	}

	public function update(Request $request, EventOrgBrochure $eventorgbrochure, User $user){

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/brochure'), $imageName);
		$eventorgbrochure->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/brochure'), $pdfName);
		$eventorgbrochure->pdf = $pdfName;	
	    }
	   	
	  	$eventorgbrochure->event_org_id = $request->input("event_org_id");
	   	$eventorgbrochure->name = $request->input("name");
	  	
	  	$eventorgbrochure->img_title = ucfirst($request->input("img_title"));
	   	$eventorgbrochure->img_alt = ucfirst($request->input("img_alt"));
		$eventorgbrochure->active_flag = $request->input("active_flag");
		$eventorgbrochure->author_id = $request->user()->id;

		$eventorgbrochure->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgbrochure->name . " was Updated.");

		return redirect()->route('eventorgbrochures.index');
	}
	public function destroy(EventOrgBrochure $eventorgbrochure)
	{
		$eventorgbrochure->active_flag = 0;
		$eventorgbrochure->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgbrochure->name . ' was De-Activated.');

		return redirect()->route('eventorgbrochures.index');
	}

	public function reactivate(EventOrgBrochure $eventorgbrochure,$id)
	{

		$eventorgbrochure = EventOrgBrochure::findOrFail($id);
		$eventorgbrochure->active_flag = 1;
		$eventorgbrochure->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgbrochure->name . ' was Re-Activated.');

		return redirect()->route('eventorgbrochures.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventOrgBrochure::findOrFail($id);
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
		Session::flash('message', 'Event Org Brochure ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventorgbrochures.index');
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\EventOrg;
use App\EventOrgInterview;
use Illuminate\Http\Request;
use \Session;

class EventOrgInterviewController extends Controller
{
	protected $model;

	public function __construct(EventOrgInterview $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventorginterviews = EventOrgInterview::whereHas('event_orgs' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventorginterviews = EventOrgInterview::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventOrgInterview::where('active_flag', 1);
		return view('eventorginterviews.index', compact('eventorginterviews', 'active'));
    }

	public function create()
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

	    return view('eventorginterviews.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventorginterviews = new EventOrgInterview();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/interview'), $imageName);
		$eventorginterviews->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/interview'), $pdfName);
		$eventorginterviews->pdf = $pdfName;	
	    }
	   	
	  	$eventorginterviews->event_org_id = $request->input("event_org_id");
	   	$eventorginterviews->name = $request->input("name");
	  	
	  	$eventorginterviews->title = ucfirst($request->input("title"));
	  	$eventorginterviews->designation = ucfirst($request->input("designation"));
	  	$eventorginterviews->img_title = ucfirst($request->input("img_title"));
	   	$eventorginterviews->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorginterviews->description = ucfirst($request->input("description"));	
		$eventorginterviews->active_flag = $request->input("active_flag");
		$eventorginterviews->author_id = $request->user()->id;

		$eventorginterviews->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorginterviews->name . " was Created.");

		return redirect()->route('eventorginterviews.index');
	}

	public function show(EventOrgInterview $eventorginterviews,$id)
	{
		$eventorginterviews = $this->model->findOrFail($id);

		return view('eventorginterviews.show', compact('eventorginterviews'));
	}
	public function edit(EventOrgInterview $eventorginterviews,$id)
	{
		$eventorginterviews = $this->model->findOrFail($id);

		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

		return view('eventorginterviews.edit', compact('eventorginterviews','eventlist'));
	}

	public function update(Request $request, EventOrgInterview $eventorginterviews, User $user,$id){
		
		$eventorginterviews = $this->model->findOrFail($id);
		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/interview'), $imageName);
		$eventorginterviews->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/interview'), $pdfName);
		$eventorginterviews->pdf = $pdfName;	
	    }
	   	
	  	$eventorginterviews->event_org_id = $request->input("event_org_id");
	   	$eventorginterviews->name = $request->input("name");
	  	
	  	$eventorginterviews->title = ucfirst($request->input("title"));
	  	$eventorginterviews->designation = ucfirst($request->input("designation"));

	  	$eventorginterviews->img_title = ucfirst($request->input("img_title"));
	   	$eventorginterviews->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorginterviews->description = ucfirst($request->input("description"));	
		$eventorginterviews->active_flag = $request->input("active_flag");
		$eventorginterviews->author_id = $request->user()->id;

		$eventorginterviews->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorginterviews->name . " was Updated.");

		return redirect()->route('eventorginterviews.index');
	}
	public function destroy(EventOrgInterview $eventorginterviews,$id)
	{
		$eventorginterviews = EventOrgInterview::findOrFail($id);		
		$eventorginterviews->active_flag = 0;
		$eventorginterviews->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorginterviews->name . ' was De-Activated.');

		return redirect()->route('eventorginterviews.index');
	}

	public function reactivate(EventOrgInterview $eventorginterviews,$id)
	{

		$eventorginterviews = EventOrgInterview::findOrFail($id);
		$eventorginterviews->active_flag = 1;
		$eventorginterviews->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorginterviews->name . ' was Re-Activated.');

		return redirect()->route('eventorginterviews.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventOrgInterview::findOrFail($id);
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
		Session::flash('message', 'Event Org Interview ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventorginterviews.index');
	}
}

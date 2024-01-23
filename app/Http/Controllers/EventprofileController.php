<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventProfile;
use Illuminate\Http\Request;
use \Session;

class EventprofileController extends Controller
{
	protected $model;

	public function __construct(EventProfile $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {

       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventprofiles = EventProfile::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventprofiles = EventProfile::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventProfile::where('active_flag', 1);
		return view('eventprofiles.index', compact('eventprofiles', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventprofiles.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		
		$eventprofile = new EventProfile();

		request()->validate([
			'event_id' => 'required',
            'org_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('org_logo')){
        $org_logoName = preg_replace('/\s+/','-',time().'-'.$request->file('org_logo')->getClientOriginalName());
        request()->org_logo->move(public_path('event/profile'), $org_logoName);
		$eventprofile->org_logo = $org_logoName;	
	    }
	    if($request->file('video')){
        $videoName = preg_replace('/\s+/','-',time().'-'.$request->file('video')->getClientOriginalName());
        request()->video->move(public_path('event/profile'), $videoName);
		$eventprofile->video = $videoName;	
	    }
	   	
	  	$eventprofile->event_id = $request->input("event_id");
	   	$eventprofile->longitude = $request->input("longitude");
	   	$eventprofile->latitude = $request->input("latitude");
	   	$eventprofile->register_btn_url = $request->input("register_btn_url");
	   	$eventprofile->exibitors_profile = ucfirst($request->input("exibitors_profile"));
	   	$eventprofile->visitor_profile = ucfirst($request->input("visitor_profile"));
	   	$eventprofile->org_logo_title = ucfirst($request->input("org_logo_title"));
	   	$eventprofile->org_logo_alt = ucfirst($request->input("org_logo_alt"));
	   	$eventprofile->org_address = ucfirst($request->input("org_address"));
	   	$eventprofile->org_contactno = $request->input("org_contactno");
		$eventprofile->org_email = $request->input("org_email");
		$eventprofile->org_website = $request->input("org_website");

		$eventprofile->active_menus = json_encode($request->input("active_menus"));
		$eventprofile->exhibitor_description = ucfirst($request->input("exhibitor_description"));
		
		$eventprofile->active_flag = $request->input("active_flag");
		$eventprofile->author_id = $request->user()->id;

		$eventprofile->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventprofile->name . " was Created.");

		return redirect()->route('eventprofiles.index');
	}

	public function show(EventProfile $eventprofile)
	{
		//$eventprofile = $this->model->findOrFail($id);

		return view('eventprofiles.show', compact('eventprofile'));
	}
	public function edit(EventProfile $eventprofile)
	{

		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

		return view('eventprofiles.edit', compact('eventprofile','eventlist'));
	}

	public function update(Request $request, EventProfile $eventprofile, User $user)
	{

	
		request()->validate([
			'event_id' => 'required',
            'org_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('event/profile');
		if($request->file('org_logo')){			
			$org_logoName = preg_replace('/\s+/','-',time().'-'.$request->file('org_logo')->getClientOriginalName());
			if(request()->org_logo->move($path, $org_logoName)){
				if(\File::exists($path.'/'.$eventprofile->org_logo)){	        		
					\File::delete($path.'/'.$eventprofile->org_logo);        	        		
				}        	
			}
			$eventprofile->org_logo = $org_logoName;	
		}
		if($request->file('video')){
			$videoName = preg_replace('/\s+/','-',time().'-'.$request->file('video')->getClientOriginalName());
			if(request()->video->move($path, $videoName)){
				if(\File::exists($path.'/'.$eventprofile->video)){	        		
					\File::delete($path.'/'.$eventprofile->video);        	        		
				}        	
			}
			$eventprofile->video = $videoName;	
		}
		
	  	$eventprofile->event_id = $request->input("event_id");
	   	$eventprofile->longitude = $request->input("longitude");
	   	$eventprofile->latitude = $request->input("latitude");
	   	$eventprofile->register_btn_url = $request->input("register_btn_url");
	   	$eventprofile->exibitors_profile = ucfirst($request->input("exibitors_profile"));
	   	$eventprofile->visitor_profile = ucfirst($request->input("visitor_profile"));
	   	$eventprofile->org_logo_title = ucfirst($request->input("org_logo_title"));
	   	$eventprofile->org_logo_alt = ucfirst($request->input("org_logo_alt"));
	   	$eventprofile->org_address = ucfirst($request->input("org_address"));
	   	$eventprofile->org_contactno = $request->input("org_contactno");
		$eventprofile->org_email = $request->input("org_email");
		$eventprofile->org_website = $request->input("org_website");

		$eventprofile->active_menus = json_encode($request->input("active_menus"));
		$eventprofile->exhibitor_description = ucfirst($request->input("exhibitor_description"));
		
		$eventprofile->active_flag = $request->input("active_flag");
		$eventprofile->author_id = $request->user()->id;

		$eventprofile->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventprofile->name . " was Updated.");

		return redirect()->route('eventprofiles.index');
	}
	public function destroy(EventProfile $eventprofile)
	{
		$eventprofile->active_flag = 0;
		$eventprofile->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventprofile->name . ' was De-Activated.');

		return redirect()->route('eventprofiles.index');
	}

	public function reactivate(EventProfile $eventprofile,$id)
	{

		$eventprofile = EventProfile::findOrFail($id);
		$eventprofile->active_flag = 1;
		$eventprofile->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventprofile->name . ' was Re-Activated.');

		return redirect()->route('eventprofiles.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventProfile::findOrFail($id);
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
		Session::flash('message', 'Event Profile ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventprofiles.index');
	}
}

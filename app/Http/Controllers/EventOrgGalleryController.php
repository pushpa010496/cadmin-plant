<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\EventOrg;
use App\EventOrgGallery;
use Illuminate\Http\Request;
use \Session;

class EventOrgGalleryController extends Controller
{
	protected $model;

	public function __construct(EventOrgGallery $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventorggallery = EventOrgGallery::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');})
	 		->orWhere('title', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventorggallery = EventOrgGallery::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventOrgGallery::where('active_flag', 1);
		return view('eventorggallery.index', compact('eventorggallery', 'active'));
    }

	public function create()
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

	    return view('eventorggallery.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventorggallery = new EventOrgGallery();

		request()->validate([
			'title' => 'required',
            'small_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'big_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('small_img')){
        $small_imgName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_img')->getClientOriginalName());
        request()->small_img->move(public_path('event/organiser/gallery'), $small_imgName);
		$eventorggallery->small_img = $small_imgName;	
	    }
	    if($request->file('big_img')){
        $big_imgName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_img')->getClientOriginalName());
        request()->big_img->move(public_path('event/organiser/gallery'), $big_imgName);
		$eventorggallery->big_img = $big_imgName;	
	    }
	   	
	  	$eventorggallery->event_org_id = $request->input("event_org_id");
	   	$eventorggallery->title = $request->input("title");
	  	
	  	$eventorggallery->img_title = ucfirst($request->input("img_title"));
	   	$eventorggallery->img_alt = ucfirst($request->input("img_alt"));
	
		$eventorggallery->active_flag = $request->input("active_flag");
		$eventorggallery->author_id = $request->user()->id;

		$eventorggallery->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorggallery->title . " was Created.");

		return redirect()->route('eventorggallery.index');
	}

	public function show(EventOrgGallery $eventorggallery)
	{
		//$eventorggallery = $this->model->findOrFail($id);

		return view('eventorggallery.show', compact('eventorggallery'));
	}
	public function edit(EventOrgGallery $eventorggallery)
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

		return view('eventorggallery.edit', compact('eventorggallery','eventlist'));
	}

	public function update(Request $request, EventOrgGallery $eventorggallery, User $user)
	{
		request()->validate([
			'title' => 'required',
            'small_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'big_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('small_img')){
        $small_imgName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_img')->getClientOriginalName());
        request()->small_img->move(public_path('event/organiser/gallery'), $small_imgName);
		$eventorggallery->small_img = $small_imgName;	
	    }
	    if($request->file('big_img')){
        $big_imgName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_img')->getClientOriginalName());
        request()->big_img->move(public_path('event/organiser/gallery'), $big_imgName);
		$eventorggallery->big_img = $big_imgName;	
	    }
	   	
	  	$eventorggallery->event_org_id = $request->input("event_org_id");
	   	$eventorggallery->title = $request->input("title");
	  	
	  	$eventorggallery->img_title = ucfirst($request->input("img_title"));
	   	$eventorggallery->img_alt = ucfirst($request->input("img_alt"));
	
		$eventorggallery->active_flag = $request->input("active_flag");
		$eventorggallery->author_id = $request->user()->id;

		$eventorggallery->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorggallery->title . " was Updated.");

		return redirect()->route('eventorggallery.index');
	}
	public function destroy(EventOrgGallery $eventorggallery)
	{
		$eventorggallery->active_flag = 0;
		$eventorggallery->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorggallery->title . ' was De-Activated.');

		return redirect()->route('eventorggallery.index');
	}

	public function reactivate(EventOrgGallery $eventorggallery,$id)
	{

		$eventorggallery = EventOrgGallery::findOrFail($id);
		$eventorggallery->active_flag = 1;
		$eventorggallery->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorggallery->title . ' was Re-Activated.');

		return redirect()->route('eventorggallery.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventOrgGallery::findOrFail($id);
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
		Session::flash('message', 'Event Org Gallery ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventorggallery.index');
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\EventOrg;
use App\EventOrgArticle;
use Illuminate\Http\Request;
use \Session;

class EventOrgArticleController extends Controller
{
	protected $model;

	public function __construct(EventOrgarticle $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventorgarticles = EventOrgArticle::whereHas('event_orgs' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventorgarticles = EventOrgArticle::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventOrgArticle::where('active_flag', 1);
		return view('eventorgarticles.index', compact('eventorgarticles', 'active'));
    }

	public function create()
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

	    return view('eventorgarticles.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventorgarticles = new EventOrgArticle();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/article'), $imageName);
		$eventorgarticles->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/article'), $pdfName);
		$eventorgarticles->pdf = $pdfName;	
	    }
	   	
	  	$eventorgarticles->event_org_id = $request->input("event_org_id");
	   	$eventorgarticles->name = $request->input("name");
	  	
	  	$eventorgarticles->img_title = ucfirst($request->input("img_title"));
	   	$eventorgarticles->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorgarticles->description = ucfirst($request->input("description"));	
		$eventorgarticles->active_flag = $request->input("active_flag");
		$eventorgarticles->author_id = $request->user()->id;

		$eventorgarticles->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgarticles->name . " was Created.");

		return redirect()->route('eventorgarticles.index');
	}

	public function show(EventOrgArticle $eventorgarticles,$id)
	{
		$eventorgarticles = $this->model->findOrFail($id);

		return view('eventorgarticles.show', compact('eventorgarticles'));
	}
	public function edit(EventOrgArticle $eventorgarticles,$id)
	{
		$eventorgarticles = $this->model->findOrFail($id);

		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

		return view('eventorgarticles.edit', compact('eventorgarticles','eventlist'));
	}

	public function update(Request $request, EventOrgArticle $eventorgarticles, User $user,$id){
		
		$eventorgarticles = $this->model->findOrFail($id);
		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/article'), $imageName);
		$eventorgarticles->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/article'), $pdfName);
		$eventorgarticles->pdf = $pdfName;	
	    }
	   	
	  	$eventorgarticles->event_org_id = $request->input("event_org_id");
	   	$eventorgarticles->name = $request->input("name");
	  	
	  	$eventorgarticles->img_title = ucfirst($request->input("img_title"));
	   	$eventorgarticles->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorgarticles->description = ucfirst($request->input("description"));	
		$eventorgarticles->active_flag = $request->input("active_flag");
		$eventorgarticles->author_id = $request->user()->id;

		$eventorgarticles->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgarticles->name . " was Updated.");

		return redirect()->route('eventorgarticles.index');
	}
	public function destroy(EventOrgArticle $eventorgarticles,$id)
	{
		$eventorgarticles = EventOrgArticle::findOrFail($id);		
		$eventorgarticles->active_flag = 0;
		$eventorgarticles->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgarticles->name . ' was De-Activated.');

		return redirect()->route('eventorgarticles.index');
	}

	public function reactivate(EventOrgArticle $eventorgarticles,$id)
	{

		$eventorgarticles = EventOrgArticle::findOrFail($id);
		$eventorgarticles->active_flag = 1;
		$eventorgarticles->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgarticles->name . ' was Re-Activated.');

		return redirect()->route('eventorgarticles.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventOrgarticle::findOrFail($id);
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
		Session::flash('message', 'Event Org article ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventorgarticles.index');
	}
}

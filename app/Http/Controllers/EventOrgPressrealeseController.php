<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\EventOrg;
use App\EventOrgPressrealese;
use Illuminate\Http\Request;
use \Session;

class EventOrgPressrealeseController extends Controller
{
	protected $model;

	public function __construct(EventOrgPressrealese $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}
	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventorgpressrealese = EventOrgPressrealese::whereHas('event_orgs' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventorgpressrealese = EventOrgPressrealese::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventOrgPressrealese::where('active_flag', 1);
		return view('eventorgpressrealese.index', compact('eventorgpressrealese', 'active'));
    }

	public function create()
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

	    return view('eventorgpressrealese.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventorgpressrealese = new EventOrgPressrealese();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/pressrealese'), $imageName);
		$eventorgpressrealese->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/pressrealese'), $pdfName);
		$eventorgpressrealese->pdf = $pdfName;	
	    }
	   	
	  	$eventorgpressrealese->event_org_id = $request->input("event_org_id");
	   	$eventorgpressrealese->name = $request->input("name");
	  	
	  	$eventorgpressrealese->img_title = ucfirst($request->input("img_title"));
	   	$eventorgpressrealese->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorgpressrealese->description = ucfirst($request->input("description"));	
		$eventorgpressrealese->active_flag = $request->input("active_flag");
		$eventorgpressrealese->author_id = $request->user()->id;

		$eventorgpressrealese->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgpressrealese->name . " was Created.");

		return redirect()->route('eventorgpressrealese.index');
	}

	public function show(EventOrgPressrealese $eventorgpressrealese)
	{
		//$eventorgpressrealese = $this->model->findOrFail($id);

		return view('eventorgpressrealese.show', compact('eventorgpressrealese'));
	}
	public function edit(EventOrgPressrealese $eventorgpressrealese)
	{
		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

		return view('eventorgpressrealese.edit', compact('eventorgpressrealese','eventlist'));
	}

	public function update(Request $request, EventOrgPressrealese $eventorgpressrealese, User $user){

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/organiser/pressrealese'), $imageName);
		$eventorgpressrealese->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('event/organiser/pressrealese'), $pdfName);
		$eventorgpressrealese->pdf = $pdfName;	
	    }
	   	
	  	$eventorgpressrealese->event_org_id = $request->input("event_org_id");
	   	$eventorgpressrealese->name = $request->input("name");
	  	
	  	$eventorgpressrealese->img_title = ucfirst($request->input("img_title"));
	   	$eventorgpressrealese->img_alt = ucfirst($request->input("img_alt"));
	   	$eventorgpressrealese->description = ucfirst($request->input("description"));	
		$eventorgpressrealese->active_flag = $request->input("active_flag");
		$eventorgpressrealese->author_id = $request->user()->id;

		$eventorgpressrealese->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventorgpressrealese->name . " was Updated.");

		return redirect()->route('eventorgpressrealese.index');
	}
	public function destroy(EventOrgPressrealese $eventorgpressrealese)
	{
		$eventorgpressrealese->active_flag = 0;
		$eventorgpressrealese->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgpressrealese->name . ' was De-Activated.');

		return redirect()->route('eventorgpressrealese.index');
	}

	public function reactivate(EventOrgPressrealese $eventorgpressrealese,$id)
	{

		$eventorgpressrealese = EventOrgPressrealese::findOrFail($id);
		$eventorgpressrealese->active_flag = 1;
		$eventorgpressrealese->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventorgpressrealese->name . ' was Re-Activated.');

		return redirect()->route('eventorgpressrealese.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventOrgPressrealese::findOrFail($id);
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
		Session::flash('message', 'Event Org Pressrealese ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventorgpressrealese.index');
	}
}

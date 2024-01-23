<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Event;
use App\EventPartner;
use Illuminate\Http\Request;
use \Session;

class EventPartnerController extends Controller
{
	protected $model;

	public function __construct(EventPartner $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$eventpartners = EventPartner::whereHas('event' , function($query) use($search) {
 			$query->where('name', 'like', '%'.$search.'%');
 			$query->where('event_type',1);})
	 		->orWhere('name', 'like', '%'.$search.'%')
	 		->where('active_flag',1)
	 		->paginate(20);
   		 }else{
   			$eventpartners = EventPartner::orderBy('id', 'desc')->paginate(10);
		 }
		 
		$active = EventPartner::where('active_flag', 1);
		return view('eventpartners.index', compact('eventpartners', 'active'));
    }

	public function create()
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

	    return view('eventpartners.create',compact('eventlist'));
	}
	public function store(Request $request, User $user)
	{
		$eventpartner = new EventPartner();

		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-small-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('event/partner'), $imageName);
		$eventpartner->image = $imageName;	
	    }
	    
	  	$eventpartner->event_id = $request->input("event_id");
	   	$eventpartner->name = $request->input("name");
	  	
	  	$eventpartner->img_title = ucfirst($request->input("img_title"));
	   	$eventpartner->img_alt = ucfirst($request->input("img_alt"));
	
		$eventpartner->active_flag = $request->input("active_flag");
		$eventpartner->author_id = $request->user()->id;

		$eventpartner->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventpartner->name . " was Created.");

		return redirect()->route('eventpartners.index');
	}

	public function show(EventPartner $eventpartner)
	{
		//$eventpartner = $this->model->findOrFail($id);

		return view('eventpartners.show', compact('eventpartner'));
	}
	public function edit(EventPartner $eventpartner)
	{
		$eventlist = Event::where('active_flag',1)->where('event_type',1)->pluck('name','id');

		return view('eventpartners.edit', compact('eventpartner','eventlist'));
	}

	public function update(Request $request, EventPartner $eventpartner, User $user)
	{
		request()->validate([
			'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
			$path = public_path('event/partner');			
			$imageName = preg_replace('/\s+/','-',time().'-small-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){
				if(\File::exists($path.'/'.$eventpartner->image)){	        		
					\File::delete($path.'/'.$eventpartner->image);        	        		
				}        	
			}
			$eventpartner->image = $imageName;	
		}
	    
	  	$eventpartner->event_id = $request->input("event_id");
	   	$eventpartner->name = $request->input("name");
	  	
	  	$eventpartner->img_title = ucfirst($request->input("img_title"));
	   	$eventpartner->img_alt = ucfirst($request->input("img_alt"));
	
		$eventpartner->active_flag = $request->input("active_flag");
		$eventpartner->author_id = $request->user()->id;

		$eventpartner->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The event " . $eventpartner->name . " was Updated.");

		return redirect()->route('eventpartners.index');
	}
	public function destroy(EventPartner $eventpartner)
	{
		$eventpartner->active_flag = 0;
		$eventpartner->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventpartner->name . ' was De-Activated.');

		return redirect()->route('eventpartners.index');
	}

	public function reactivate(EventPartner $eventpartner,$id)
	{

		$eventpartner = EventPartner::findOrFail($id);
		$eventpartner->active_flag = 1;
		$eventpartner->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The event ' . $eventpartner->name . ' was Re-Activated.');

		return redirect()->route('eventpartners.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventPartner::findOrFail($id);
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
		Session::flash('message', 'Event Partner ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('eventpartners.index');
	}
}

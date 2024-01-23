<?php

namespace App\Http\Controllers;

use App\SeoEvent;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\SeoCompany;
use App\Event;
use \Session;

class SeoEventController extends Controller
{
   protected $model;
    public function __construct(SeoCompany $model)
    {
    $this->middleware('auth');
    $this->model = $model;
    }
   public function index(Request $request)
    {
        if($request->get('search')){
        $search = \Request::get('search');
            $seoevent = SeoEvent::where('meta_title', 'like', '%'.$search.'%')
            ->paginate(20);
         }else{
            $seoevent = SeoEvent::orderBy('id', 'desc')->paginate(10);
         }
    
        $active = SeoEvent::where('active_flag', 1);
        return view('seoevents.index', compact('seoevent', 'active'));
    }

    public function create()
    {
        $eventlist = Event::where('active_flag',1)->pluck('name','id');
        return view('seoevents.create',compact('eventlist'));        
    }
    public function store(Request $request, User $user)
    {
        $seoevent = new SeoEvent();

        request()->validate([
            'event_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
        
        $seoevent->pages = $request->input("pages");      
        $seoevent->meta_title = $request->input("meta_title");
        $seoevent->meta_keywords = $request->input("meta_keywords");
        $seoevent->meta_description = $request->input("meta_description");
        $seoevent->og_title = $request->input("og_title");
        $seoevent->og_description = $request->input("og_description");
        $seoevent->og_keywords = $request->input("og_keywords");
        $seoevent->og_image = $request->input("og_image");
        $seoevent->og_video = $request->input("og_video");
        $seoevent->meta_region = $request->input("meta_region");
        $seoevent->meta_position = $request->input("meta_position");
        $seoevent->meta_icbm = $request->input("meta_icbm");
    
        $seoevent->active_flag = 1;
        $seoevent->author_id = $request->user()->id;

        $comp = Event::find($request->input("event_id"));
        $comp->eventseo()->save($seoevent);

        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company SEO " . $seoevent->meta_title ." was Created.");

        return redirect()->route('seoevents.index');
    }
    public function show(SeoEvent $seoevent)
    {
        return view('seoevents.show', compact('seoevent'));

    }
    public function edit($id)
    {   
        $value = SeoEvent::findOrFail($id);
        $eventlist = Event::where('active_flag',1)->pluck('name','id');

        return view('seoevents.edit', compact('value','eventlist'));
    }
    public function update(Request $request, SeoEvent $seoevent, User $user)
    {
        request()->validate([
            'event_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
        
        $seoevent->pages = $request->input("pages");      
        $seoevent->meta_title = $request->input("meta_title");
        $seoevent->meta_keywords = $request->input("meta_keywords");
        $seoevent->meta_description = $request->input("meta_description");
        $seoevent->og_title = $request->input("og_title");
        $seoevent->og_description = $request->input("og_description");
        $seoevent->og_keywords = $request->input("og_keywords");
        $seoevent->og_image = $request->input("og_image");
        $seoevent->og_video = $request->input("og_video");
        $seoevent->meta_region = $request->input("meta_region");
        $seoevent->meta_position = $request->input("meta_position");
        $seoevent->meta_icbm = $request->input("meta_icbm");
    
        $seoevent->active_flag = 1;
        $seoevent->author_id = $request->user()->id;
                
        $comp = Event::find($request->input("event_id"));
        $comp->eventseo()->save($seoevent);
        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company SEO " . $seoevent->meta_title ." was Created.");

        return redirect()->route('seoevents.index');
    }
    public function destroy(SeoEvent $company,$id){
        $seoevent = SeoEvent::findOrFail($id);
        $seoevent->active_flag = 0;
        $seoevent->save();

        Session::flash('message_type', 'negative');
        Session::flash('message_icon', 'hide');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The company profile ' . $seoevent->title . ' was De-Activated.');

        return redirect()->route('seoevents.index');
    }
    public function reactivate(SeoEvent $company,$id){
        $seoevent = SeoEvent::findOrFail($id);
        $seoevent->active_flag = 1;
        $seoevent->save();
        Session::flash('message_type', 'success');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The company profile ' . $seoevent->title . ' was Re-Activated.');

        return redirect()->route('seoevents.index');
    }
}

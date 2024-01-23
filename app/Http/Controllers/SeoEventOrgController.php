<?php

namespace App\Http\Controllers;

use App\SeoEventOrg;
use Illuminate\Http\Request;
use App\EventOrg;
use Session;

class SeoEventOrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;
    public function __construct(SeoEventOrg $model)
    {
    $this->middleware('auth');
    $this->model = $model;
    }

    public function index(Request $request)
    {
      

       
            $seoeventorg = SeoEventOrg::orderBy('id', 'desc')->paginate(10);
         return view('seoeventorgs.index',compact('seoeventorg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eventorgs = EventOrg::where('active_flag',1)->pluck('name','id');
        return view('seoeventorgs.create',compact('eventorgs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seoeventorg = new SeoEventOrg();

        request()->validate([
            'seo_event_org_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
        
        $seoeventorg->pages = $request->input("pages");      
        $seoeventorg->meta_title = $request->input("meta_title");
        $seoeventorg->meta_keywords = $request->input("meta_keywords");
        $seoeventorg->meta_description = $request->input("meta_description");
        $seoeventorg->og_title = $request->input("og_title");
        $seoeventorg->og_description = $request->input("og_description");
        $seoeventorg->og_keywords = $request->input("og_keywords");
        $seoeventorg->og_image = $request->input("og_image");
        $seoeventorg->og_video = $request->input("og_video");
        $seoeventorg->meta_region = $request->input("meta_region");
        $seoeventorg->meta_position = $request->input("meta_position");
        $seoeventorg->meta_icbm = $request->input("meta_icbm");
    
        $seoeventorg->active_flag = 1;
        $seoeventorg->author_id = $request->user()->id;
                
        $comp = EventOrg::find($request->input("seo_event_org_id"));
        $comp->seoorg()->save($seoeventorg);

        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The SEO Event orgs  " . $seoeventorg->meta_title ." was Created.");

        return redirect()->route('seoeventorg.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SeoEventOrg  $seoEventOrg
     * @return \Illuminate\Http\Response
     */
    public function show(SeoEventOrg $seoeventorg)
    {

        
        return view('seoeventorgs.show',compact('seoeventorg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SeoEventOrg  $seoEventOrg
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $value = SeoEventOrg::findOrFail($id);
        $evntorglist = EventOrg::where('active_flag',1)->pluck('name','id');

        return view('seoeventorgs.edit',compact('value','evntorglist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SeoEventOrg  $seoEventOrg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeoEventOrg $seoeventorg)
    {

            
        request()->validate([
            'seo_event_org_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
        
        $seoeventorg->pages = $request->input("pages");      
        $seoeventorg->meta_title = $request->input("meta_title");
        $seoeventorg->meta_keywords = $request->input("meta_keywords");
        $seoeventorg->meta_description = $request->input("meta_description");
        $seoeventorg->og_title = $request->input("og_title");
        $seoeventorg->og_description = $request->input("og_description");
        $seoeventorg->og_keywords = $request->input("og_keywords");
        $seoeventorg->og_image = $request->input("og_image");
        $seoeventorg->og_video = $request->input("og_video");
        $seoeventorg->meta_region = $request->input("meta_region");
        $seoeventorg->meta_position = $request->input("meta_position");
        $seoeventorg->meta_icbm = $request->input("meta_icbm");
    
        $seoeventorg->active_flag = 1;
        $seoeventorg->author_id = $request->user()->id;
                
        $comp = EventOrg::find($request->input("seo_event_org_id"));
        $comp->seoorg()->save($seoeventorg);
        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The  SEO Event  orgs " . $seoeventorg->meta_title ." was Updated.");

        return redirect()->route('seoeventorg.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SeoEventOrg  $seoEventOrg
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeoEventOrg $seoEventOrg)
    {
        //
    }
}

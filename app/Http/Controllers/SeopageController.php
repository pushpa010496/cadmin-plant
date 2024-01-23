<?php

namespace App\Http\Controllers;

use App\SeoPage;
use App\Page;
use Illuminate\Http\Request;
use Session;

class SeopageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(SeoPage $model)
    {
        $this->model = $model;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        
            $seopage = SeoPage::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
          /* $page = SeoPage::find(1)->seop;
            print_r($page);die;*/

        return view('seopage.index', compact('seopage', 'active'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = Page::where('active_flag',1)->pluck('title','id');


        return view('seopage.create',compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seopages = new SeoPage();

        request()->validate([
            'page_id' => 'required',
            'meta_title'=>'required'
        ]);
        
            
        $seopages->meta_title = $request->input("meta_title");
        $seopages->meta_keywords = $request->input("meta_keywords");
        $seopages->meta_description = $request->input("meta_description");
        $seopages->og_title = $request->input("meta_title");
        $seopages->og_description = $request->input("meta_description");
        $seopages->og_keywords = $request->input("og_keywords");
        $seopages->og_image = $request->input("og_image");
        $seopages->og_video = $request->input("og_video");
        $seopages->meta_region = $request->input("meta_region");
        $seopages->meta_position = $request->input("meta_position");
        $seopages->meta_icbm = $request->input("meta_icbm");
        
        $seopages->active_flag = 1;
        $seopages->author_id = $request->user()->id;
                
        $page = Page::find($request->input("page_id"));
        $page->seop()->save($seopages);

        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company SEO " . $seopages->meta_title ." was Created.");

        return redirect()->route('seopage.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seopage  $seopage
     * @return \Illuminate\Http\Response
     */
    public function show(Seopage $seopage)
    {


        return view('seopage.show',compact('seopage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seopage  $seopage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pages = Page::where('active_flag',1)->pluck('title','id');

        $value = SeoPage::find($id);
        return view('seopage.edit',compact('pages','value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seopage  $seopage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeoPage $seopage)
    {
         request()->validate([
            'page_id' => 'required',
            'meta_title'=>'required'
        ]);
        
            
        $seopage->meta_title = $request->input("meta_title");
        $seopage->meta_keywords = $request->input("meta_keywords");
        $seopage->meta_description = $request->input("meta_description");
        $seopage->og_title = $request->input("meta_title");
        $seopage->og_description = $request->input("meta_description");
        $seopage->og_keywords = $request->input("og_keywords");
        $seopage->og_image = $request->input("og_image");
        $seopage->og_video = $request->input("og_video");
        $seopage->meta_region = $request->input("meta_region");
        $seopage->meta_position = $request->input("meta_position");
        $seopage->meta_icbm = $request->input("meta_icbm");
        
        $seopage->active_flag = 1;
        $seopage->author_id = $request->user()->id;
                
        $page = Page::find($request->input("page_id"));
        $page->seop()->save($seopage);

        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company SEO " . $seopage->meta_title ." was Created.");

        return redirect()->route('seopage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seopage  $seopage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seopage $seopage)
    { 

        $page = SeoPage::find($seopage->id);
         
        $page->active_flag = 0;
        
         $page->save();

         Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company SEO " . $seopage->meta_title ." was Inactivated.");
       return redirect()->back();
    }
        public function metatag(Request $request, $id){
        
        $meta = SeoPage::findOrFail($id);
        $meta->meta_title = $request->input("meta_title");
        $meta->meta_keywords = $request->input("meta_keywords");
        $meta->meta_description = $request->input("meta_description");
        $meta->og_title = $request->input("meta_title");
        $meta->og_description = $request->input("meta_description");
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
        Session::flash('message', 'The Seo Page ' . $meta->meta_title . ' Metatags was Updated.');

        return redirect()->back();
    }
}

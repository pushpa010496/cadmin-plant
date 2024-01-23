<?php

namespace App\Http\Controllers;

use App\CompanyProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyCatalog;
use App\Company;
use \Session;
use File;

class CompanyProjectController extends Controller
{
  protected $model;
    public function __construct(CompanyProject $model)
    {
        $this->middleware('auth');
        $this->model = $model;
    }
    public function index(Request $request)
    {
        if($request->get('search')){
        $search = \Request::get('search');
            $companyprojects = CompanyProject::whereHas('company' , function($query) use($search) {
            $query->where('comp_name', 'like', '%'.$search.'%');})
            ->orwhere('title', 'like', '%'.$search.'%')
            ->paginate(20);
         }else{
            $companyprojects = CompanyProject::orderBy('id', 'desc')->paginate(10);
         }
    
        $active = CompanyProject::where('active_flag', 1);
        return view('companyprojects.index', compact('companyprojects', 'active'));
    }

    public function create()
    {
        $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        return view('companyprojects.create',compact('companylist'));       
    }
    public function store(Request $request, User $user)
    {
        $comp = $request->input("company_id");
        $company = Company::where('id',$comp)->select('comp_name')->first();

        $comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
        $companyc = new CompanyProject();

        request()->validate([
            'title' => 'required|max:255|unique:company_profiles',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'            
        ]);
        if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/project', $imageName);
        $companyc->image = $imageName;  
        }
        if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/project', $pdfName);
        $companyc->pdf = $pdfName;  
        }
         $companyc->meta_keywords = $request->input("title");
        $companyc->meta_title = ''.$company->comp_name.' | project | Plant automation-technology';      
        $companyc->og_title = ''.$company->comp_name.' | project | Plant automation-technology';        
        $companyc->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
        $companyc->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
        $companyc->og_keywords = $request->input("title");
        $companyc->og_image = $request->input("url");
        

        $companyc->title = ucfirst($request->input("title"));       
        $companyc->title_tag = ucfirst($request->input("title_tag"));
        $companyc->alt_tag = ucfirst($request->input("alt_tag"));
        $companyc->active_flag = $request->input("active_flag");
        $companyc->stage = $request->stage;
        $companyc->author_id = $request->user()->id;
        $companyc->type = 'admin';      
        $comp = Company::find($request->input("company_id"));
        $comp->companyprojects()->save($companyc);
        $compro = CompanyProfile::find($request->input("company_profile_id"));
        $compro->pproject()->save($companyc);

        return redirect()->route('companyprojects.index');
    }
    public function show(CompanyProject $companyproject)
    {
        
        return view('companyprojects.show', compact('companyproject'));
    }
    public function edit(CompanyProject $companyproject){   
        $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        $profilelist = CompanyProfile::where('active_flag',1)->where('company_id',$companyproject->company_id)->pluck('title','id');
        $profile = CompanyProfile::where('active_flag',1)->where('company_id',$companyproject->company_id)->select('url')->first();
        return view('companyprojects.edit', compact('companyproject','companylist','profilelist','profile'));
    }
    public function update(Request $request, CompanyProject $companyproject, User $user){
        $comp = $request->input("company_id");
        $company = Company::where('id',$comp)->select('comp_name')->first();
        $comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
        request()->validate([
            'title' => 'required|max:255|unique:company_profiles',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'            
        ]);

         if($request->company_id != $companyproject->company->id){      
            $oldPath = public_path('suppliers').'/'.str_slug($companyproject->company->comp_name).'/project/';
            $newPath = public_path('suppliers').'/'.str_slug($company->comp_name).'/project/';      
            //small image
            if($companyproject->image){
                if (copy($oldPath.$companyproject->image, $newPath.$companyproject->image)) {
                    \File::delete($oldPath.$companyproject->image);
                }
            }
            //big image
            if($companyproject->pdf){
                if (copy($oldPath.$companyproject->pdf, $newPath.$companyproject->pdf)) {
                    \File::delete($oldPath.$companyproject->pdf);
                }
            }
            
        }
        
        $path = public_path('suppliers').'/'.str_slug($company->comp_name).'/project';
        if($request->file('image')){
            $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
            if(request()->image->move($path, $imageName)){               
                if(File::exists($path.'/'.$companyproject->image)){                 
                    \File::delete($path.'/'.$companyproject->image);                            
                }   
            }

        // $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        // request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog', $imageName);
        $companyproject->image = $imageName;    
        }
        if($request->file('pdf')){
            $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
            if(request()->pdf->move($path, $pdfName)){
                if(File::exists($path.'/'.$companyproject->pdf)){                   
                    \File::delete($path.'/'.$companyproject->pdf);                          
                }  
            }
            $companyproject->pdf = $pdfName;
        }
        
        $companyproject->title = ucfirst($request->input("title"));     
        $companyproject->title_tag = ucfirst($request->input("title_tag"));
        $companyproject->alt_tag = ucfirst($request->input("alt_tag"));
        $companyproject->active_flag = $request->input("active_flag");
        $companyproject->stage = $request->stage;
        $companyproject->author_id = $request->user()->id;
                
        $comp = Company::find($request->input("company_id"));
        $comp->companyprojects()->save($companyproject);
        $compro = CompanyProfile::find($request->input("company_profile_id"));
        $compro->pproject()->save($companyproject);


        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The company profile \"<a href='companyprojects/$companyproject->slug'>" . $companyproject->title . "</a>\" was Updated.");

        return redirect()->route('companyprojects.index');
    }



    public function destroy(CompanyProject $companyprojects,$id){
        $companyprojects = CompanyProject::findOrFail($id);
        $companyprojects->active_flag = 0;
        $companyprojects->stage = 0;
        $companyprojects->save();

        Session::flash('message_type', 'negative');
        Session::flash('message_icon', 'hide');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The company profile ' . $companyprojects->title . ' was De-Activated.');

        return redirect()->route('companyprojects.index');
    }
    public function reactivate(CompanyProject $companyprojects,$id){
        $companyprojects = CompanyProject::findOrFail($id);
        $companyprojects->active_flag = 1;
        $companyprojects->stage = 1;
        $companyprojects->save();
        Session::flash('message_type', 'success');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The company profile ' . $companyprojects->title . ' was Re-Activated.');

        return redirect()->route('companyprojects.index');
    }
    public function selectAjax(Request $request){

        if($request){
            $profiles = CompanyProfile::where('company_id',$request->company_id)->pluck("title","id")->all();

            $data = view('ajax-select',compact('profiles'))->render();
            return response()->json(['options'=>$data]);
        }
        
    }
    public function metatag(Request $request,$id){
        $meta = CompanyProject::findOrFail($id);
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
        Session::flash('message', 'The Company Catalog ' . $meta->meta_title . ' Metatags was added.');


        return redirect()->route('companyprojects.index');
    }
}

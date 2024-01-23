<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyCatalog;
use App\Company;
use \Session;
use File;

class CompanyCatalogController extends Controller
{
	protected $model;
	public function __construct(CompanyCatalog $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search');
 			$companycatalogs = CompanyCatalog::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->orwhere('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companycatalogs = CompanyCatalog::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = CompanyCatalog::where('active_flag', 1);
		return view('companycatalogs.index', compact('companycatalogs', 'active'));
    }

    public function create()
	{
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('companycatalogs.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();

		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		$companyc = new companyCatalog();

		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'image' => 'required'            
        ]);
        if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog', $imageName);
		$companyc->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog', $pdfName);
		$companyc->pdf = $pdfName;	
	    }
	     $companyc->meta_keywords = $request->input("title");
		$companyc->meta_title = ''.$company->comp_name.' | catalog | Plant automation-technology';		
		$companyc->og_title = ''.$company->comp_name.' | catalog | Plant automation-technology';		
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
		$companyc->display_order = $request->input("display_order");
		$comp = Company::find($request->input("company_id"));
		$comp->companycatalogs()->save($companyc);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pcatalog()->save($companyc);

		return redirect()->route('companycatalogs.index');
	}
	public function show(CompanyCatalog $companycatalog)
	{
		
		return view('companycatalogs.show', compact('companycatalog'));
	}
	public function edit(CompanyCatalog $companycatalog){   
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		$profilelist = CompanyProfile::where('active_flag',1)->where('company_id',$companycatalog->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companycatalog->company_id)->select('url')->first();
        return view('companycatalogs.edit', compact('companycatalog','companylist','profilelist','profile'));
	}
	public function update(Request $request, CompanyCatalog $companycatalog, User $user){
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
                       
        ]);

         if($request->company_id != $companycatalog->company->id){		
			$oldPath = public_path('suppliers').'/'.str_slug($companycatalog->company->comp_name).'/catalog/';
			$newPath = public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog/';		
			//small image
			if($companycatalog->image){
				if (copy($oldPath.$companycatalog->image, $newPath.$companycatalog->image)) {
					\File::delete($oldPath.$companycatalog->image);
				}
			}
			//big image
			if($companycatalog->pdf){
				if (copy($oldPath.$companycatalog->pdf, $newPath.$companycatalog->pdf)) {
					\File::delete($oldPath.$companycatalog->pdf);
				}
			}
			
		}
		
      	$path = public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog';
        if($request->file('image')){
	        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
	        if(request()->image->move($path, $imageName)){	        	 
	        	if(File::exists($path.'/'.$companycatalog->image)){	        		
					\File::delete($path.'/'.$companycatalog->image);        	        		
				}   
	        }

        // $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        // request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/catalog', $imageName);
		$companycatalog->image = $imageName;	


	    }
	    if($request->file('pdf')){
		    $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
	        if(request()->pdf->move($path, $pdfName)){
	        	if(File::exists($path.'/'.$companycatalog->pdf)){	        		
					\File::delete($path.'/'.$companycatalog->pdf);        	        		
				}  
	        }
	        $companycatalog->pdf = $pdfName;
	    }
		
		$companycatalog->title = ucfirst($request->input("title"));		
		$companycatalog->title_tag = ucfirst($request->input("title_tag"));
		$companycatalog->alt_tag = ucfirst($request->input("alt_tag"));
		$companycatalog->active_flag = $request->input("active_flag");
		$companycatalog->stage = $request->stage;
		$companycatalog->author_id = $request->user()->id;
		$companycatalog->display_order = $request->input("display_order");
				
		$comp = Company::find($request->input("company_id"));
		$comp->companycatalogs()->save($companycatalog);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pcatalog()->save($companycatalog);


		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='companycatalogs/$companycatalog->slug'>" . $companycatalog->title . "</a>\" was Updated.");

		return redirect()->route('companycatalogs.index');
	}



	public function destroy(CompanyCatalog $companycatalogs,$id){
		$companycatalogs = CompanyCatalog::findOrFail($id);
		$companycatalogs->active_flag = 0;
		$companycatalogs->stage = 0;
		$companycatalogs->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companycatalogs->title . ' was De-Activated.');

		return redirect()->route('companycatalogs.index');
	}
	public function reactivate(CompanyCatalog $companycatalogs,$id){
		$companycatalogs = CompanyCatalog::findOrFail($id);
		$companycatalogs->active_flag = 1;
		$companycatalogs->stage = 1;
		$companycatalogs->save();
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companycatalogs->title . ' was Re-Activated.');

		return redirect()->route('companycatalogs.index');
	}
	public function selectAjax(Request $request){

    	if($request){
    		$profiles = CompanyProfile::where('company_id',$request->company_id)->pluck("title","id")->all();

    		$data = view('ajax-select',compact('profiles'))->render();
    		return response()->json(['options'=>$data]);
       	}
       	
	}
	public function metatag(Request $request,$id){
		$meta = CompanyCatalog::findOrFail($id);
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


		return redirect()->route('companycatalogs.index');
   	}
}

<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyPressrealese;
use App\Company;
use \Session;
use File;

class CompanyPressrealeseController extends Controller
{
	protected $model;
	public function __construct(CompanyPressrealese $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search');
 			$companypressrealeses = CompanyPressrealese::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->orwhere('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companypressrealeses = CompanyPressrealese::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = CompanyPressrealese::where('active_flag', 1);
		return view('companypressrealeses.index', compact('companypressrealeses', 'active'));
    }

    public function create()
	{
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('companypressrealeses.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
	
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'image' => 'required'            
        ]);
        
        $comp = $request->input("company_id");
		$company = Company::find($comp);
		$comprofile = CompanyProfile::where('company_id',$comp)->first();
		$companyc = new CompanyPressrealese();
		
        if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese', $imageName);
		$companyc->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese', $pdfName);
		$companyc->pdf = $pdfName;	
	    }
		$companyc->meta_keywords = $request->input("title");
		$companyc->meta_title = ''.$company->comp_name.' | pressrealese | Plant automation-technology';		
		$companyc->og_title = ''.$company->comp_name.' | pressrealese | Plant automation-technology';		
		$companyc->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
		$companyc->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
		
		$companyc->og_keywords = $request->input("title");
		$companyc->og_image = $request->input("url");
		$companyc->title = ucfirst($request->input("title"));		
		$companyc->title_tag = ucfirst($request->input("title_tag"));
		$companyc->alt_tag = ucfirst($request->input("alt_tag"));
		$companyc->active_flag = $request->input("active_flag");
		$companyc->stage = $request->stage;
		$companyc->stage = $request->input("stage");
		$companyc->author_id = $request->user()->id;
		$companyc->type = 'admin';
		$companyc->company_id = $company->id;
		$companyc->company_profile_id = $comprofile->id;
        $companyc->save();
		return redirect()->route('companypressrealeses.index');
	}
	public function show(CompanyPressrealese $companypressrealese)
	{
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companypressrealese->company_id)->select('url')->first();
		return view('companypressrealeses.show', compact('companypressrealese','profile'));
	}
	public function edit(CompanyPressrealese $companypressrealese){   
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		$profilelist = CompanyProfile::where('active_flag',1)->where('company_id',$companypressrealese->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companypressrealese->company_id)->select('url')->first();
        return view('companypressrealeses.edit', compact('companypressrealese','companylist','profilelist','profile'));
	}
	public function update(Request $request, CompanyPressrealese $companypressrealese, User $user){
	
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'            
        ]);

         if($request->company_id != $companypressrealese->company->id){		
			$oldPath = public_path('suppliers').'/'.str_slug($companypressrealese->company->comp_name).'/pressrealese/';
			$newPath = public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese/';		
			//small image
			if($companypressrealese->image){
				if (copy($oldPath.$companypressrealese->image, $newPath.$companypressrealese->image)) {
					\File::delete($oldPath.$companypressrealese->image);
				}
			}
			//big image
			if($companypressrealese->pdf){
				if (copy($oldPath.$companypressrealese->pdf, $newPath.$companypressrealese->pdf)) {
					\File::delete($oldPath.$companypressrealese->pdf);
				}
			}
			
		}


		$path = public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese';
		if($request->file('image')){
			$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){	       
				if(File::exists($path.'/'.$companypressrealese->image)){	        		
					\File::delete($path.'/'.$companypressrealese->image);        	        		
				}     
			}
        // $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        // request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese', $imageName);
			$companypressrealese->image = $imageName;	
		}
		if($request->file('pdf')){
			$pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
			if(request()->pdf->move($path, $pdfName)){
				if(File::exists($path.'/'.$companypressrealese->pdf)){	        		
					\File::delete($path.'/'.$companypressrealese->pdf);        	        		
				}          
			}
        // $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        // request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/pressrealese', $pdfName);
			$companypressrealese->pdf = $pdfName;	
		}
		
		$companypressrealese->title = ucfirst($request->input("title"));		
		$companypressrealese->title_tag = ucfirst($request->input("title_tag"));
		$companypressrealese->alt_tag = ucfirst($request->input("alt_tag"));
		$companypressrealese->active_flag = $request->input("active_flag");
		$companypressrealese->stage = $request->stage;
		$companypressrealese->stage = $request->input("stage");
		$companypressrealese->author_id = $request->user()->id;
				
		$comp = Company::find($request->input("company_id"));
		$comp->companypress()->save($companypressrealese);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->ppress()->save($companypressrealese);


		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='CompanyPressrealeses/$companypressrealese->slug'>" . $companypressrealese->title . "</a>\" was Updated.");

		return redirect()->route('companypressrealeses.index');
	}



	public function destroy(CompanyPressrealese $companypressrealeses,$id){
		$companypressrealeses = CompanyPressrealese::findOrFail($id);
		$companypressrealeses->active_flag = 0;
		$companypressrealeses->stage = 0;
		$companypressrealeses->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companypressrealeses->title . ' was De-Activated.');

		return redirect()->route('companypressrealeses.index');
	}
	public function reactivate(CompanyPressrealese $companypressrealeses,$id){
		$companypressrealeses = CompanyPressrealese::findOrFail($id);
		$companypressrealeses->active_flag = 1;
		$companypressrealeses->stage = 1;
		$companypressrealeses->save();
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companypressrealeses->title . ' was Re-Activated.');

		return redirect()->route('companypressrealeses.index');
	}
	public function selectAjax(Request $request){

    	if($request){
    		$profiles = CompanyProfile::where('company_id',$request->company_id)->where('active_flag',1)->pluck("title","id")->all();

    		$data = view('ajax-select',compact('profiles'))->render();
    		return response()->json(['options'=>$data]);
       	}
   	}
   	public function metatag(Request $request,$id){
		$meta = CompanyPressrealese::findOrFail($id);
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
		Session::flash('message', 'The company pressrealeses ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('companypressrealeses.index');
	}
}

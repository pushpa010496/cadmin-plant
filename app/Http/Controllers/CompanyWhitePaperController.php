<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyWhitePaper;
use App\Company;
use \Session;
use File;

class CompanyWhitePaperController extends Controller
{
	protected $model;
	public function __construct(CompanyWhitepaper $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
    	
       	if($request->get('search')){
		$search = \Request::get('search');
 			$companywhitepapers = CompanyWhitepaper::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->orwhere('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companywhitepapers = CompanyWhitepaper::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = CompanyWhitepaper::where('active_flag', 1);
		return view('companywhitepapers.index', compact('companywhitepapers', 'active'));
    }

    public function create()
	{
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('companywhitepapers.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		$companyc = new CompanyWhitepaper();

		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'image' => 'required'            
        ]);
        if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/whitepaper', $imageName);
		$companyc->image = $imageName;	
	    }
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/whitepaper', $pdfName);
		$companyc->pdf = $pdfName;	
	    }
	    $companyc->meta_keywords = $request->input("title");
		$companyc->meta_title = ''.$company->comp_name.' | whitepapers| Plant automation-technology';		
		$companyc->og_title = ''.$company->comp_name.' | whitepapers| Plant automation-technology';		
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
		$comp->companywp()->save($companyc);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pwp()->save($companyc);

		return redirect()->route('companywhitepapers.index');
	}
	public function show(CompanyWhitepaper $companywhitepaper)
	{
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companywhitepaper->company_id)->select('url')->first();
		return view('companywhitepapers.show', compact('companywhitepaper','profile'));
	}
	public function edit(CompanyWhitepaper $companywhitepaper){   
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		$profilelist = CompanyProfile::where('active_flag',1)->where('company_id',$companywhitepaper->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companywhitepaper->company_id)->select('url')->first();
        return view('companywhitepapers.edit', compact('companywhitepaper','companylist','profilelist','profile'));
	}
	public function update(Request $request, CompanyWhitepaper $companywhitepaper, User $user){
		$comp = $request->input("company_id");
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'            
        ]);

         if($request->company_id != $companywhitepaper->company->id){		
			$oldPath = public_path('suppliers').'/'.str_slug($companywhitepaper->company->comp_name).'/whitepaper/';
			$newPath = public_path('suppliers').'/'.str_slug($comp_url->comp_name).'/whitepaper/';		
			//small image
			if($companywhitepaper->image){
				if (copy($oldPath.$companywhitepaper->image, $newPath.$companywhitepaper->image)) {
					\File::delete($oldPath.$companywhitepaper->image);
				}
			}
			//big image
			if($companywhitepaper->pdf){
				if (copy($oldPath.$companywhitepaper->pdf, $newPath.$companywhitepaper->pdf)) {
					\File::delete($oldPath.$companywhitepaper->pdf);
				}
			}
			
		}

		$path = public_path('suppliers').'/'.str_slug($companywhitepaper->company->comp_name).'/whitepaper';
		if($request->file('image')){
			$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){
				
				if(File::exists($path.'/'.$companywhitepaper->image)){	        		
					\File::delete($path.'/'.$companywhitepaper->image);        	        		
				}      
			}
        // $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        // request()->image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/whitepaper', $imageName);
			$companywhitepaper->image = $imageName;	
		}
		if($request->file('pdf')){
			$pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
			if(request()->pdf->move($path, $pdfName)){
				
				if(File::exists($path.'/'.$companywhitepaper->pdf)){	        		
					\File::delete($path.'/'.$companywhitepaper->pdf);        	        		
				}       
			}
        // $pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('pdf')->getClientOriginalName());
        // request()->pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/whitepaper', $pdfName);
			$companywhitepaper->pdf = $pdfName;	
		}
		
		$companywhitepaper->title = ucfirst($request->input("title"));		
		$companywhitepaper->title_tag = ucfirst($request->input("title_tag"));
		$companywhitepaper->alt_tag = ucfirst($request->input("alt_tag"));
		$companywhitepaper->active_flag = $request->input("active_flag");
		$companywhitepaper->stage = $request->stage;
		$companywhitepaper->author_id = $request->user()->id;
				
		$comp = Company::find($request->input("company_id"));
		$comp->companywp()->save($companywhitepaper);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pwp()->save($companywhitepaper);


		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='companywhitepapers/$companywhitepaper->slug'>" . $companywhitepaper->title . "</a>\" was Updated.");

		return redirect()->route('companywhitepapers.index');
	}



	public function destroy(CompanyWhitepaper $companywhitepapers,$id){
		$companywhitepapers = CompanyWhitepaper::findOrFail($id);
		$companywhitepapers->active_flag = 0;
		$companywhitepapers->stage = 0;
		$companywhitepapers->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companywhitepapers->title . ' was De-Activated.');

		return redirect()->route('companywhitepapers.index');
	}
	public function reactivate(CompanyWhitepaper $companywhitepapers,$id){
		$companywhitepapers = CompanyWhitepaper::findOrFail($id);
		$companywhitepapers->active_flag = 1;
		$companywhitepapers->stage = 1;
		$companywhitepapers->save();
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companywhitepapers->title . ' was Re-Activated.');

		return redirect()->route('companywhitepapers.index');
	}
	public function selectAjax(Request $request){

    	if($request){
    		$profiles = CompanyProfile::where('company_id',$request->company_id)->where('active_flag',1)->pluck("title","id")->all();

    		$data = view('ajax-select',compact('profiles'))->render();
    		return response()->json(['options'=>$data]);
       	}
   	}
   	public function metatag(Request $request,$id){
		$meta = CompanyWhitepaper::findOrFail($id);
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
		Session::flash('message', 'The Company Whitepaper ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('companywhitepapers.index');
	}
}

<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyProfileOrg;
use App\Company;
use \Session;
use  DB;

class CompanyProfileController extends Controller
{
	protected $model;
	public function __construct(CompanyProfile $model)
	{
	$this->middleware('auth');
	$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search');
 			$companyprofile = CompanyProfile::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companyprofile = CompanyProfile::orderBy('id', 'desc')->paginate(10);
		 }
 	
		    $active = CompanyProfile::where('active_flag', 1);

		 /* $active = CompanyProfile::where('profile_type','FP')->get();
        
		 foreach ($active as $key => $value) {
		 	  $affected = DB::table('company_profiles')
              ->where('id',$value->id)
              ->update(['url' =>str_slug($value->title)]);
		 }*/



		return view('companyprofile.index', compact('companyprofile', 'active'));
    }

    public function create()
	{
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('companyprofile.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();

		$companyp = new CompanyProfile();
		$companyporg = new CompanyProfileOrg();

		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'url' => 'required|max:255|unique:company_profiles'
        ]);
        $companyp->title = ucfirst($request->input("title"));
		$companyp->meta_keywords = $request->input("title");
		$companyp->meta_title = ''.$company->comp_name.' | Plant automation-technology';		
		$companyp->og_title = ''.$company->comp_name.' | Plant automation-technology';		
		$companyp->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
		$companyp->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';;
		$companyp->og_keywords = $request->input("title");
		$companyp->og_image = $request->input("url");		
		
		$companyp->title = ucfirst($request->input("title"));		
		$companyp->url = str_slug($request->input("url"));		
		$companyp->company_id = $request->input("company_id");		
		$companyp->description = $request->input("description");		
		$companyp->active_menus = json_encode($request->input("active_menus"));
	
		$companyp->active_flag = $request->input("active_flag");
		$companyp->author_id = $request->user()->id;
				
		$comp = Company::find($request->input("company_id"));
		$comp->companyprofile()->save($companyp);
		return redirect()->route('companyprofile.index');
	}
	public function show(CompanyProfile $companyprofile)
	{
		return view('companyprofile.show', compact('companyprofile'));

	}
	public function edit(CompanyProfile $companyprofile)
	{   
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');

        return view('companyprofile.edit', compact('companyprofile','companylist'));
	}
	public function update(Request $request, CompanyProfile $companyprofile, User $user)
	{
		request()->validate([
			'title' => 'required|max:255',
            'url' => 'required|max:255'
        ]);
		
		 if($companyprofile->title != $request->title){
		 	$oldname = public_path('suppliers').'/'.str_slug($companyprofile->title);	
		 	$newname = public_path('suppliers').'/'.str_slug($request->title);	
		 	rename($oldname,$newname);
		 	
		 }

		$companyprofile->title = ucfirst($request->input("title"));		
		$companyprofile->url = str_slug($request->input("url"));		
		$companyprofile->company_id = $request->input("company_id");		
		$companyprofile->description = $request->input("description");		
		$companyprofile->active_menus = json_encode($request->input("active_menus"));
	
		$companyprofile->active_flag = $request->input("active_flag");
		$companyprofile->author_id = $request->user()->id;
				
		$comp = Company::find($request->input("company_id"));
		$comp->companyprofile()->save($companyprofile);
	//	$company->technology()->sync($request->input("technologies"));

		$cmp_profile = company::where('id',$comp->id)->first();
		
		$cmp_profile->comp_name = $request->input("title");
		
		$cmp_profile->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='companyprofile/$companyprofile->slug'>" . $companyprofile->title . "</a>\" was Updated.");

		return redirect()->route('companyprofile.index');
	}



	public function destroy(CompanyProfile $company,$id){
		$companyprofile = CompanyProfile::findOrFail($id);
		$companyprofile->active_flag = 0;
		$companyprofile->save();

		$company->pcatalog()->update(['active_flag' => 0]);
		$company->ppress()->update(['active_flag' => 0]);
		$company->pwp()->update(['active_flag' => 0]);
		$company->pvideo()->update(['active_flag' => 0]);
		$company->pproduct()->update(['active_flag' => 0]);
		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companyprofile->title . ' was De-Activated.');

		return redirect()->route('companyprofile.index');
	}
	public function reactivate(CompanyProfile $company,$id){
		$companyprofile = CompanyProfile::findOrFail($id);
		$companyprofile->active_flag = 1;
		$companyprofile->save();
		$company->pcatalog()->update(['active_flag' => 1]);
		$company->ppress()->update(['active_flag' => 1]);
		$company->pwp()->update(['active_flag' => 1]);
		$company->pvideo()->update(['active_flag' => 1]);
		$company->pproduct()->update(['active_flag' => 1]);
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companyprofile->title . ' was Re-Activated.');

		return redirect()->route('companyprofile.index');
	}
	public function metatag(Request $request,$id){
		$meta = CompanyProfile::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("meta_title");
		$meta->og_description = $request->input("meta_title");
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
		Session::flash('message', 'The Company Profile ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('companyprofile.index');
	}
}

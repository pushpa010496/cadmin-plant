<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\SeoCompany;
use App\CompanyProfile;
use \Session;

class SeoCompanyController extends Controller
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
 			$seocompany = SeoCompany::whereHas('seocompanypro' , function($query) use($search) {
 			$query->where('title', 'like', '%'.$search.'%');})->orwhere('meta_title', 'like', '%'.$search.'%')
	 		->paginate(20);

	 		//print_r($seocompany); die;
   		 }else{
   			$seocompany = SeoCompany::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = SeoCompany::where('active_flag', 1);
		return view('seocompany.index', compact('seocompany', 'active'));
    }

    public function create()
	{
		$companylist = CompanyProfile::where('active_flag',1)->pluck('title','id');
		return view('seocompany.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$seocompany = new SeoCompany();

		request()->validate([
			'company_profile_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
		
		$seocompany->pages = $request->input("pages");		
		$seocompany->meta_title = $request->input("meta_title");
		$seocompany->meta_keywords = $request->input("meta_keywords");
		$seocompany->meta_description = $request->input("meta_description");
		$seocompany->og_title = $request->input("meta_title");
		$seocompany->og_description = $request->input("meta_description");
		$seocompany->og_keywords = $request->input("meta_keywords");
		$seocompany->og_image = $request->input("og_image");
		$seocompany->og_video = $request->input("og_video");
		$seocompany->meta_region = $request->input("meta_region");
		$seocompany->meta_position = $request->input("meta_position");
		$seocompany->meta_icbm = $request->input("meta_icbm");
	
		$seocompany->active_flag = 1;
		$seocompany->author_id = $request->user()->id;
				
		$comp = CompanyProfile::find($request->input("company_profile_id"));
		$comp->pseocomp()->save($seocompany);

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company SEO " . $seocompany->meta_title ." was Created.");

		return redirect()->route('seocompanies.index');
	}
	public function show(SeoCompany $seocompany)
	{
		return view('seocompany.show', compact('seocompany'));

	}
	public function edit($id)
	{   
		$value = SeoCompany::findOrFail($id);
		$companylist = CompanyProfile::where('active_flag',1)->pluck('title','id');

        return view('seocompany.edit', compact('value','companylist'));
	}
	public function update(Request $request, SeoCompany $seocompany, User $user)
	{
		request()->validate([
			'company_profile_id' => 'required',
            'pages' => 'required',
            'meta_title'=>'required'
        ]);
		
		$seocompany->pages = $request->input("pages");		
		$seocompany->meta_title = $request->input("meta_title");
		$seocompany->meta_keywords = $request->input("meta_keywords");
		$seocompany->meta_description = $request->input("meta_description");
		$seocompany->og_title = $request->input("meta_title");
		$seocompany->og_description = $request->input("meta_description");
		$seocompany->og_keywords = $request->input("og_keywords");
		$seocompany->og_image = $request->input("og_image");
		$seocompany->og_video = $request->input("og_video");
		$seocompany->meta_region = $request->input("meta_region");
		$seocompany->meta_position = $request->input("meta_position");
		$seocompany->meta_icbm = $request->input("meta_icbm");
	
		$seocompany->active_flag = 1;
		$seocompany->author_id = $request->user()->id;
				
		$comp = CompanyProfile::find($request->input("company_profile_id"));
		$comp->pseocomp()->save($seocompany);
		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company SEO " . $seocompany->meta_title ." was Created.");

		return redirect()->route('seocompanies.index');
	}
	public function destroy(SeoCompany $company,$id){
		$seocompany = SeoCompany::findOrFail($id);
		$seocompany->active_flag = 0;
		$seocompany->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $seocompany->title . ' was De-Activated.');

		return redirect()->route('seocompanies.index');
	}
	public function reactivate(SeoCompany $company,$id){
		$seocompany = SeoCompany::findOrFail($id);
		$seocompany->active_flag = 1;
		$seocompany->save();
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $seocompany->title . ' was Re-Activated.');

		return redirect()->route('seocompanies.index');
	}
}

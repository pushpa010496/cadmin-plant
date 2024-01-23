<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\CompanyVideo;
use App\Company;
use \Session;
use File;

class CompanyVideoController extends Controller
{
	protected $model;
	public function __construct(CompanyVideo $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search');
 			$companyvideos = CompanyVideo::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->orwhere('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companyvideos = CompanyVideo::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = CompanyVideo::where('active_flag', 1);
		return view('companyvideos.index', compact('companyvideos', 'active'));
    }

    public function create()
	{
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('companyvideos.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		$companyv = new CompanyVideo();

		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'video' => 'mimes:mp4,mov,ogg,qt|max:200000'   
        ]);
	    if($request->file('video')){
        $videoName = preg_replace('/\s+/','-',time().'-'.$request->file('video')->getClientOriginalName());
        request()->video->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/video', $videoName);
		$companyv->video = $videoName;	
	    }
	    $companyv->meta_keywords = $request->input("title");
		$companyv->meta_title = ''.$company->comp_name.' | video| Plantautomation';		
		$companyv->og_title = ''.$company->comp_name.' | video | Plantautomation';		
		$companyv->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';
		$companyv->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$request->input("title").'';;
		$companyv->og_keywords = $request->input("title");
		$companyv->og_image = $request->input("url");
		
		$companyv->title = ucfirst($request->input("title"));		
		$companyv->active_flag = $request->input("active_flag");
		$companyv->stage = $request->stage;
		$companyv->author_id = $request->user()->id;
		$companyv->type = 'admin';	
		$comp = Company::find($request->input("company_id"));
		$comp->companyvideo()->save($companyv);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pvideo()->save($companyv);

		return redirect()->route('companyvideos.index');
	}
	public function show(CompanyVideo $companyvideo)
	{
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companyvideo->company_id)->select('url')->first();
		return view('companyvideos.show', compact('companyvideo','profile'));
	}
	public function edit(CompanyVideo $companyvideo){   
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		$profilelist = CompanyProfile::where('active_flag',1)->where('company_id',$companyvideo->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$companyvideo->company_id)->select('url')->first();
        return view('companyvideos.edit', compact('companyvideo','companylist','profilelist','profile'));
	}
	public function update(Request $request, CompanyVideo $companyvideo, User $user){
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
            'video' => 'mimetypes:video/avi,video/mpeg,video/mp4,video/quicktime|max:200000',
                       
        ]);
      
       if($request->company_id != $companyvideo->company->id){		
			$oldPath = public_path('suppliers').'/'.str_slug($companyvideo->company->comp_name).'/video/';
			$newPath = public_path('suppliers').'/'.str_slug($comp_url->comp_name).'/video/';		
			//small image
			if($companyvideo->video){
				if (copy($oldPath.$companyvideo->image, $newPath.$companyvideo->video)) {
					unlink($oldPath.$companyvideo->video);
				}
			}						
		}

		$path = public_path('suppliers').'/'.str_slug($company->comp_name).'/video';
	    if($request->file('video')){
	    	 $videoName = preg_replace('/\s+/','-',time().'-'.$request->file('video')->getClientOriginalName());
        		 if(request()->video->move($path, $videoName)){	        		
	        		if(File::exists($path.'/'.$companyvideo->video)){	        		
					\File::delete($path.'/'.$companyvideo->video);        	        		
				}      
	        }
        // $videoName = preg_replace('/\s+/','-',time().'-'.$request->file('video')->getClientOriginalName());
        // request()->video->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/video', $videoName);
		$companyvideo->video = $videoName;	
	    }
		
		$companyvideo->title = ucfirst($request->input("title"));		
		$companyvideo->active_flag = $request->input("active_flag");
		$companyvideo->stage = $request->stage;
		$companyvideo->author_id = $request->user()->id;
				
		$comp = Company::find($request->input("company_id"));
		$comp->companyvideo()->save($companyvideo);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pvideo()->save($companyvideo);


		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='companyvideos/$companyvideo->slug'>" . $companyvideo->title . "</a>\" was Updated.");

		return redirect()->route('companyvideos.index');
	}



	public function destroy(CompanyVideo $companyvideos,$id){
		$companyvideos = CompanyVideo::findOrFail($id);
		$companyvideos->active_flag = 0;
		$companyvideos->stage = 0;
		$companyvideos->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companyvideos->title . ' was De-Activated.');

		return redirect()->route('companyvideos.index');
	}
	public function reactivate(CompanyVideo $companyvideos,$id){
		$companyvideos = CompanyVideo::findOrFail($id);
		$companyvideos->active_flag = 1;
		$companyvideos->stage = 1;
		$companyvideos->save();
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $companyvideos->title . ' was Re-Activated.');

		return redirect()->route('companyvideos.index');
	}
	public function metatag(Request $request,$id){
		$meta = CompanyVideo::findOrFail($id);
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
		Session::flash('message', 'company video ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('companyvideos.index');
	}
	
}

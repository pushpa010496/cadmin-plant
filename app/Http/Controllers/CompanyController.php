<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Company;
use App\CompanyOrg;
use App\CompanyProfile;
use \Session;
use File;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\CompanyInactive;
use App\Tracklink;
use App\CompanyEnquiry;
use App\CompanyHistory;
class companyController extends Controller
{
	protected $model;
	public function __construct(company $model)
	{
		        $this->middleware('auth');

		$this->model = $model;
	}
    public function index(Request $request)
    {

       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$companies = Company::where('comp_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$companies = Company::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Company::where('active_flag', 1);
		return view('companies.index', compact('companies', 'active'));
    }

    public function create()
	{
		$company = $this->model->get();		
        return view('companies.create',compact('company'));		
	}
	public function store(Request $request, User $user)
	{

		$role = 6;
		$company = new company();
		$companyorg = new companyorg();

		request()->validate([
			'comp_name' => 'required|max:255|unique:companies',
            'comp_logo' => 'required'
        ]);

        
             $alphabet = "ochremedia0123456789@#$%^*_!&?";
             $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
               $pass = []; //remember to declare $pass as an array
             	for ($i = 0; $i < 8; $i++) {
             		$n = rand(0, $alphaLength);
             		$pass[] = $alphabet[$n];
             	}
	             $password=implode($pass); //turn the array into a string
	             $hashed=bcrypt($password);
	            
		
		if($request->file('comp_logo')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('comp_logo')->getClientOriginalName());
        request()->comp_logo->move(public_path('suppliers').'/'.str_slug($request->input("comp_name")), $imageName);
		$company->comp_logo = $imageName;	
	    }

	    if($request->file('banner_image')){
         $banner_Name =   str_slug($request->comp_name).'-banner.'.$request->banner_image->getClientOriginalExtension(); 
        request()->banner_image->move(public_path('suppliers').'/'.str_slug($request->input("comp_name")), $banner_Name);
		$company->banner_image = $banner_Name;	
	    }

		$company->comp_name = $request->input("comp_name");		
		$company->contact_name = ucfirst($request->input("contact_name"));		
		$company->email = $request->input("email");		
		$company->phone = $request->input("phone");		
		$company->start_date = date("Y-m-d H:i:s",strtotime($request->input("start_date")));
		$company->end_date = date("Y-m-d H:i:s",strtotime($request->input("end_date")));	
		$company->country = $request->input("country");		
		$company->website = $request->input("website");		
		$company->fax = $request->input("fax");		
		$company->address = $request->input("address");		
		$company->profile_type = $request->profile_type;
		$company->active_flag = 1;
		$company->author_id = $request->user()->id;
		$company->banner_url = $request->banner_url;
		$company->product_url = $request->product_url;
		$company->linkedin = $request->linkedin;
		$company->twitter = $request->twitter;
		$company->facebook = $request->facebook;
		$company->youtube = $request->youtube;
		$company->instagram = $request->instagram;
		$company->email1 = $request->email1;
		$company->package = $request->package;
		@$services=implode(",",$request->services);
		$company->services = $services;
		
		$company->save();
		request()->validate([
		    'email' => 'required|string|email|max:255|unique:users'
		]);

		$user = new User();
		$user->name = $request->input("comp_name");
		$user->email = $request->input("email");
		//$user->password = $request->password ? bcrypt($request->password) : bcrypt('123456');

		 $user->client_token = $password;
	     $user->password = $hashed;
		$user->active_flag = 1;
		$user->save();
		$user->attachRole($role);

		 $data = [
            'company'=>$request->input("company"),
            'email'=>$request->input("email"),
            'password'=>$request->input("password"),
           ];


           //track url
        $linkgen = new Tracklink();
        $linkgen->type ="company";
        $linkgen->title ="Company Urls";

           $linkgen->oriurl = $company->website;
           $titleid=rand();
           $randam=rand();
           $linkgen->oriurl =$company->website;
           $linkgen->shorturl_id=date('Ymdhis').$randam;

           if($linkgen->oriurl !=""){
       		$tracklink = new Tracklink();
       		$tracklink->setConnection('mysql2');
       		$tracklink->type =  "company";
       		$tracklink->title =  "company";
       		$tracklink->oriurl =  $linkgen->oriurl;
       		$tracklink->shorturl_id =  $linkgen->shorturl_id;
       		$tracklink->titleid =  $titleid;
       		$tracklink->save();
		    $track_url = 'http://track.plantautomation-technology.com/'.$linkgen->shorturl_id;
   			$company->track_url = $track_url;
   			$company->track_id = $tracklink->id;
   			$company->save();

          }
			//track url end           
		// Mail::send('emails.registration.admin', $data, function($message) use ($data) {
  //       $message->to('omplenquiry@ochre-media.com');   
  //       $message->subject('New User Signed Up for packaging labelling!');
  //       });
  
  
		return redirect()->route('companies.index');
	}
	public function show(company $company)
	{
		return view('companies.show', compact('company'));

	}
	public function edit(company $company)
	{
		
	    $companies = Company::all();
	   // $technologies = Technology::where('active_flag', 1)->orderBy('tech_name')->pluck('tech_name', 'id');
		    
        return view('companies.edit', compact('company','companies'));
	}
	public function update(Request $request, company $company, User $user)
	{
    if ($request->has('company')) {
		     //track url
		if($company->website !=""){
			$tracklink = Tracklink::on('mysql2')->find($company->track_id);
				if(empty($tracklink)){
					// create short link
						$tracklinks = new Tracklink();
						$tracklinks->setConnection('mysql2');
						$tracklinks->type =  "company";
						$tracklinks->title =  $request->comp_name;
						$tracklinks->oriurl =  $request->website;
						$tracklinks->shorturl_id =  date('Ymdhis').rand();
						$tracklinks->titleid =  rand();
						$tracklinks->save();

						$track_url = 'http://track.plantautomation-technology.com/'.$tracklinks->shorturl_id;
						$company->track_url = $track_url;
						$company->track_id = $tracklinks->id;
						$company->save();
					//end short link
					}else{
					$tracklink->oriurl =  $request->website;
					$tracklink->save();
					}
				}
		//track URL end
		  if($company->comp_name != $request->comp_name){
		 	$oldname = public_path('suppliers').'/'.str_slug($company->comp_name);	
		 	$newname = public_path('suppliers').'/'.str_slug($request->comp_name);	
		 	rename($oldname,$newname);
		 }
		if($request->file('comp_logo')){
			$path = public_path('suppliers').'/'.str_slug($request->input("comp_name"));	
	        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('comp_logo')->getClientOriginalName());        
	        if(request()->comp_logo->move($path, $imageName)){
	        	if(File::exists($path.'/'.$company->comp_logo)){	        		
	        		// \File::delete($path.'/'.$company->comp_logo);        		
	        	}    
	        }
			$company->comp_logo = $imageName;	
	    }
	    if($request->file('banner_image')){
			$path = public_path('suppliers').'/'.str_slug($request->comp_name);		
	         $banner_Name =  str_slug($request->comp_name).'-banner.'.$request->banner_image->getClientOriginalExtension();      
	        if(request()->banner_image->move($path, $banner_Name)){
	        	if(File::exists($path.'/'.$company->banner_image)){	        		
	        		// \File::delete($path.'/'.$company->banner_image);	
	        	}	        	    
	        }
			$company->banner_image = $banner_Name;	
	    }
		$user = User::where('email',$company->email)->first();
		$user->name = $request->input("comp_name");
		$user->email = $request->input("email");
		$user->save();
		$company->comp_name = $request->input("comp_name");		
		//$company->contact_name = ucfirst($request->input("contact_name"));		
		$company->email = $request->input("email");		
		$company->phone = $request->input("phone");		
		$company->start_date = date("Y-m-d H:i:s",strtotime($request->input("start_date")));		
		$company->end_date = date("Y-m-d H:i:s",strtotime($request->input("end_date")));		
		$company->country = $request->input("country");		
		$company->website = $request->input("website");		
		$company->fax = $request->input("fax");		
		$company->address = $request->input("address");		
		$company->active_flag = $request->active_flag;
		$company->profile_type = $request->profile_type;
		$company->author_id = $request->user()->id;
		$company->banner_url = $request->banner_url;
		$company->product_url = $request->product_url;
		$company->linkedin = $request->linkedin;
		$company->twitter = $request->twitter;
		$company->facebook = $request->facebook;
		$company->youtube = $request->youtube;
		$company->instagram = $request->instagram;
		//$company->email1 = $request->email1;
		$company->profileclaim = $request->profile_type;
		$company->package = $request->package;
		$services=implode(",",$request->services);
		$company->services = $services;
	}
			if ($request->has('contact_details')) {
			$company->contact_name = ucfirst($request->input("contact_name"));
			$company->job_title = $request->job_title;
			$company->contact_email = $request->contact_email;
			$company->contact_mobile = $request->contact_mobile;
			$company->email1 = $request->email1;
			}
			/*billing details*/
			if($request->has('billing')){
				$company->billing_comp_name = $request->billing_comp_name;
				$company->billing_contact_person = $request->billing_contact_person;
				$company->billing_contact_number = $request->billing_contact_number;
				$company->billing_address = $request->billing_address;
				$company->billing_country = $request->billing_country;
				$company->billing_email = $request->billing_email;
				$company->billing_value = $request->billing_value;
				$company->vat_tax_gst = $request->vat_tax_gst;
				$company->po_no = $request->po_no;
				$company->po_date = $request->po_date;
				$company->tax = $request->tax;
			}
		$company->save();
		/*company history*/
		$company_history = new CompanyHistory([$company->id,$company->start_date,$company->end_date,$company->services]);
		$company_history->start_date = date("Y-m-d H:i:s",strtotime($request->input("start_date")));		
		$company_history->end_date = date("Y-m-d H:i:s",strtotime($request->input("end_date")));
		$company_history->company_id=$company->id;
	    // $services=implode(",",$request->services);
		// $company_history->services =$services;
		$company_history->author_id = $request->user()->id;
		$company_history->form_type = $request->form_type;
		$company_history->save();
		$cmp_profile = CompanyProfile::where('company_id',$company->id)->first();
		$cmp_profile->title = $request->input("comp_name");
		$cmp_profile->save();
		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company \"<a href='companies/$company->slug'>" . $company->comp_name . "</a>\" was Updated.");

		return redirect()->route('companies.index');
	}
	public function destroy(Company $company)
	{
		$company->active_flag = 0;
		$company->save();
		$company->companyprofile()->update(['active_flag' => 0]);
		$company->companycatalogs()->update(['active_flag' => 0,'stage' => 0]);
		$company->companypress()->update(['active_flag' => 0,'stage' => 0]);
		$company->companywp()->update(['active_flag' => 0,'stage' => 0]);
		$company->companyvideo()->update(['active_flag' => 0,'stage' => 0]);
		$company->companyproduct()->update(['active_flag' => 0,'stage' => 0]);
		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Company ' . $company->comp_name . ' was De-Activated.');

		return redirect()->route('companies.index');
	}
	public function reactivate(Company $company,$id)
	{

		$company = Company::findOrFail($id);
		$company->active_flag = 1;
		$company->save();
		$company->companyprofile()->update(['active_flag' => 1]);
		$company->companycatalogs()->update(['active_flag' => 1,'stage' => 1]);
		$company->companypress()->update(['active_flag' => 1,'stage' => 1]);
		$company->companywp()->update(['active_flag' => 1,'stage' => 1]);
		$company->companyvideo()->update(['active_flag' => 1,'stage' => 1]);
		$company->companyproduct()->update(['active_flag' => 1,'stage' => 1]);
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Company ' . $company->comp_name . ' was Re-Activated.');

		return redirect()->route('companies.index');
	}
	public function metatag(Request $request,$id){
		
		$meta = Company::findOrFail($id);
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
		Session::flash('message', 'The Company ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('companies.index');
	}

	public function companyInactive(){
		$date = new \DateTime();
		$from = $date->modify('-80 days')->format('Y-m-d H:i:s');
		$companies =   Company::whereDate('start_date', '>=', $from)->get();
		$data = $companies;
		Mail::to('nagaraj@ochre-media.com')
		->send(new CompanyInactive($data));
		
		return 'Mail has been send successfully';
	}

	
}

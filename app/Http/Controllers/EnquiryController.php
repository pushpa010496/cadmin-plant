<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\Product;
use App\Company;
use \Session;
use App\Category;
use File;
use Mail;
use DB;
use Config;
use Excel;
use App\DataConnecting;
use App\CompanyEnquiry;

class EnquiryController extends Controller
{
	protected $model;
	public function __construct(Product $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
    	
    	if($request->get('search')){
    		
			$search = \Request::get('search'); //<-- we use global request to get the param of URI
			$companies = Company::where('email', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->withCount('enquiries')->orderBy('enquiries_count', 'desc')->paginate(20);
			$companies->appends(['search' => $search]);
		}else{
			 // $companies = Company::orderBy('id', 'desc')->paginate(10);

			$companies = Company::withCount('enquiries')->orderBy('enquiries_count', 'desc')->paginate(10);

		}
		$active = Company::where('active_flag', 1);
		return view('enquiry.index', compact('companies', 'active'));
	}

	 public function show(Company $company)
    {    	
    	 // $company= $company->enquiries;
		return view('enquiry.show', compact('company'));
	}


	public function exportdata(Company $company)
	{
		

		 $tbl_info='company_enquiries';

		if(isset($tbl_info)){

      //header('Content-Type: text/csv; charset=utf-8');  
     // header('Content-Disposition: attachment; filename=data.csv');  
     // $output = fopen("php://output", "w");  

			// $data = DB::table($tbl_info)->get()->toArray();


			// foreach ($data as $trackinfo) {

			// 	$urlinfoArray[] = $trackinfo;


			// }
			$data =[];
			foreach ($company->enquiries as $key => $value) {

				$data[$key]['page'] =  $value->page;
				$data[$key]['company_id'] = $value->company_id !=null ? Company::find($value->company_id)->comp_name : '';
				$data[$key]['product'] = $value->product_id !=null ? Product::find($value->product_id)->title : '' ; 
				$data[$key]['name'] =$value->name;
				$data[$key]['source'] =$value->source;
				$data[$key]['title'] =$value->title;
				$data[$key]['company'] =$value->company;
				$data[$key]['country'] =$value->country;
				$data[$key]['email'] =$value->email;
				$data[$key]['telephone'] =$value->telephone;
				$data[$key]['message'] =$value->message;
				$data[$key]['date'] = $value->created_at->format('d/M/Y H:i:s');
			}



			$array = json_decode(json_encode($data), True); 

			return Excel::create('companyEnquiries', function($excel) use ($array) {

				$excel->sheet('Enquiries', function($sheet) use ($array)
				{
					$sheet->fromArray($array);
					$sheet->row(1, function($row) {
                // call cell manipulation methods
						$row->setBackground('#FFFF00');

					});
				});
			})->download('xlsx');

		}


	}

// Route::get('company-enquiries/exportall','EnquiryController@exportAllCompanyEnquiries')->name('company.exportalldata');
	
// 	<a href="{{ route('company.exportalldata') }}" class="btn btn-primary pull-right">  Export All data </a>	
	
	public function exportAllCompanyEnquiries()
	{

		$companies = Company::withCount('enquiries')->orderBy('enquiries_count', 'desc')->get();
		$data =[];		 
		foreach ($companies as $key => $company) {

			$data[$key]['comapny'] =  $company->comp_name;
			$data[$key]['contact_person'] = $company->contact_name;
			$data[$key]['email'] =$company->email;
			$data[$key]['phone'] =$company->phone;
			$data[$key]['country'] =$company->country;
			$data[$key]['profile_type'] = $company->profile_type; 
			$data[$key]['status'] = $company->active_flag == 1 ? 'Active' : 'In Active';
			$data[$key]['marketing'] = $company->enquiries()->where('source','Marketing')->count() != 0 ? $company->enquiries()->where('source','Marketing')->count():0;
			$data[$key]['direct'] = $company->enquiries()->where('source','Direct')->count() != 0 ? $company->enquiries()->where('source','Direct')->count() : 0;
			$data[$key]['enquiries'] = $company->enquiries()->count() == '' ? '0': $company->enquiries()->count();

		}

		$array = json_decode(json_encode($data), True); 
		return Excel::create('companyEnquiries', function($excel) use ($array) {

			$excel->sheet('Enquiries', function($sheet) use ($array)
			{
				$sheet->fromArray($array);
				$sheet->row(1, function($row) {
                // call cell manipulation methods
					$row->setBackground('#FFFF00');

				});
			});
		})->download('xlsx');
	}

	public function mapping(Request $request){

		$companies = Company::orderBy('id', 'desc')->pluck('comp_name','id')->prepend('--  Select Company --','');
		if($request->get('search')){
			$search = \Request::get('search'); //<-- we use global request to get the param of URI
			$enquiries = CompanyEnquiry::where('email', 'like', '%'.$search.'%')->paginate(20);
			$enquiries->appends(['search' => $search]);


		}else{
			$enquiries = CompanyEnquiry::where('company_id',null)->orderBy('id', 'desc')->paginate(10);
		}

		return view('enquiry.mapping', compact('companies', 'enquiries'));
	}

	public function postMapping(Request $request,CompanyEnquiry $enquiry){
		$enquiry->company_id = $request->company_id;
		$enquiry->save();
		return redirect()->back();

	}

	public function newReports(){
		ini_set('memory_limit', '-1');

	 	$companies = Company::all();

	 	$cmp_data =[];		 
	 	foreach ($companies as $key => $company) {
	 		$cmp_data[$key]['comapny'] =  $company->comp_name;
	 		$cmp_data[$key]['contact_person'] = $company->contact_name;
	 		$cmp_data[$key]['email'] =$company->email;
	 		$cmp_data[$key]['phone'] =$company->phone;
	 		$cmp_data[$key]['country'] =$company->country;
	 		$cmp_data[$key]['profile_status'] = $company->active_flag == 1? 'Active':'In Active';
	 		$cmp_data[$key]['products'] = $company->companyproduct->where('active_flag',1)->where('stage',1)->count() == '' ? '0': $company->companyproduct->where('active_flag',1)->where('stage',1)->count();
	 		$cmp_data[$key]['live_date'] = date('d-m-Y', strtotime($company->created_at));
	 		$cmp_data[$key]['start_date'] = date('d-m-Y', strtotime($company->start_date));
	 		$cmp_data[$key]['end_date'] = date('d-m-Y', strtotime($company->end_date));

	 	}

	 	$array = json_decode(json_encode($cmp_data), True); 
	 	return Excel::create('plant_companies', function($excel) use ($array) {

	 		$excel->sheet('company_list', function($sheet) use ($array)
	 		{
	 			$sheet->fromArray($array);
	 			$sheet->row(1, function($row) {
   
	 				$row->setBackground('#FFFF00');

	 			});
	 		});
	 	})->download('xlsx');

		// $categories = Category::where('id','!=',22)->get();
		// $cat_data =[];
		// foreach ($categories as $key => $category) {		
		// 	$companies = [];
		//  	foreach ($category->products->where('active_flag',1)->where('stage',1) as  $value) {
		 		
		//  		if(!in_array($value->company->comp_name, $companies, true)){
		//  			array_push($companies, $value->company->comp_name);
		//  		}
		//  	}
		 	
		// 	$cat_data[$key]['name'] =  $category->name;
	 // 		$cat_data[$key]['products'] = $category->products->where('active_flag',1)->where('stage',1)->count() == '' ? '0': $category->products->where('active_flag',1)->where('stage',1)->count();
	 
	 // 		$cat_data[$key]['companies'] =implode(" , ",$companies);
	 		
		// }

		// $array = json_decode(json_encode($cat_data), True); 
		// return Excel::create('plant_categories', function($excel) use ($array) {

		// 	$excel->sheet('categories_list', function($sheet) use ($array)
		// 	{	
				
		// 		$sheet->fromArray($array);
		// 		$sheet->row(1, function($row) {

		// 			$row->setBackground('#FFFF00');


		// 		});
		// 	});

		// })->download('xlsx');

		// $companies = Company::all();

	 // 	$cmp_data =[];		 
	 // 	foreach ($companies as $key => $company) {
	 // 		$cmp_data[$key]['comapny'] =  $company->comp_name;
	 // 		$cmp_data[$key]['company_id'] = $company->id;
	 		

	 // 	}

	 // 	$array = json_decode(json_encode($cmp_data), True); 
	 // 	return Excel::create('plant_company_ids', function($excel) use ($array) {

	 // 		$excel->sheet('company_list', function($sheet) use ($array)
	 // 		{
	 // 			$sheet->fromArray($array);
	 // 			$sheet->row(1, function($row) {
   
	 // 				$row->setBackground('#FFFF00');

	 // 			});
	 // 		});
	 // 	})->download('xlsx');
	}

	public function catReports(){
		ini_set('memory_limit', '-1');

	 	$products = Product::all();

	 	$cmp_data =[];		 
	 	foreach ($products as $key => $product) {
return $product->load('categories');
	 		$cmp_data[$key]['category'] =  @$product->categories[0]->name;
	 		$cmp_data[$key]['product_title'] =  $product->title;
	 		$cmp_data[$key]['product_status'] = $product->active_flag == 1? 'Active':'In Active';	 		
	 		$cmp_data[$key]['comapny'] =  $product->company->comp_name;
	 		$cmp_data[$key]['company_status'] = $product->company->active_flag == 1? 'Active':'In Active';
	 		$cmp_data[$key]['contact_person'] = $product->company->contact_name;
	 		$cmp_data[$key]['email'] =$product->company->email;
	 		$cmp_data[$key]['phone'] =$product->company->phone;
	 		$cmp_data[$key]['country'] =$product->company->country;
	 	}

	 	$array = json_decode(json_encode($cmp_data), True); 
	 	return Excel::create('plant_products', function($excel) use ($array) {

	 		$excel->sheet('product_list', function($sheet) use ($array)
	 		{
	 			$sheet->fromArray($array);
	 			$sheet->row(1, function($row) {
   
	 				$row->setBackground('#FFFF00');

	 			});
	 		});
	 	})->download('xlsx');
	}

	public function enquiryList(){
		$data = CompanyEnquiry::orderBy('id','desc')->paginate(20);
		return view('enquiry.enquirylist', compact('data'));

	}

	public function enquiryShow(CompanyEnquiry $enquiry){
		$model = 'enquiry';
		$error = null;
		try {
            // Get information
			
			return view('enquiry.modal_enquiry_show', compact('enquiry','error','model'));
		} catch (GroupNotFoundException $e) {
			// $error = trans('admin/groups/message.group_not_found', compact('id'));
			// return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}

	}

	public function enquirySend(Request $request){
		

		return $enquiries = CompanyEnquiry::whereIn('id',$request->enquiries)->get(); 

		foreach ($enquiries as $key => $enquiry) {
				//return $enquiry->companies->email;
				// if($enquiry->companies->enq_email){
				   if($enquiry->companies->email1){
				   	
					// $emails = explode(',',$enquiry->companies->enq_email);
					// $email_list=[];
					// foreach ($emails as $key => $email) {
					// 	$email_list[] =  $enquiry->companies->$email;							
					// }
				 $email_list = explode(",",trim($enquiry->companies->email1));
				 foreach ($email_list as  $value) {
				 
				
					$data = [
						'name'=>$enquiry->name,
						'email'=>$enquiry->email,
						'company'=>$enquiry->company,
						'phone'=>$enquiry->telephone,						
						'country' =>$enquiry->country,					
            			'description'=>$enquiry->message
					];
	
					Mail::send('emails.enquiry', $data, function($message) use ($value,$data)
					{    
						$message->to($value)->subject('New enquiry- plantautomation Technology-'.$data['company']);    
					});

					$enquiry->sent_to_client = 1;
					$enquiry->save();
					 }
				}
		}

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "Enquiries sent successfully...");

		return redirect()->back()->with('success','Enquiries sent successfully to the clients...');
	}
	public function enquiryEdit(CompanyEnquiry $enquiry){
		$model = 'enquiry';
		$error = null;
		try {
            // Get information
			
			return view('enquiry.modal_enquiry_edit', compact('enquiry','error','model'));
		} catch (GroupNotFoundException $e) {
			// $error = trans('admin/groups/message.group_not_found', compact('id'));
			// return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}

	}
	public function enquiryUpdate(Request $request,CompanyEnquiry $enquiry){

		//return $request;
			$enuqiry_id = $request->input('id');
			$enquiry = CompanyEnquiry::where('id',$enuqiry_id)->first();
			$enquiry->name = $request->input("name");
			$enquiry->email = $request->input("email");
			$enquiry->company = $request->input("comp_name");
			$enquiry->telephone = $request->input("telephone");
			$enquiry->country = $request->input("country");
			$enquiry->message = $request->input("message");

			$enquiry->save();

		return redirect()->back();

	}


}

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
use App\CompanyHistory;

class CompanyhistoryController extends Controller
{
    protected $model;
    public function __construct(Product $model)
    {
        $this->middleware('auth');
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->get('search')){
            
            $search = \Request::get('search'); //<-- we use global request to get the param of URI
            $companies = Company::where('email', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orderBy('id', 'desc')->where('active_flag', 1)->get();
            $companies->appends(['search' => $search]);
        }else{
             // $companies = Company::orderBy('id', 'desc')->paginate(10);

            $companies = Company::orderBy('id', 'desc')->get();

        }
        $active = Company::where('active_flag', 1);
        return view('history.index', compact('companies', 'active'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
        $company_history=CompanyHistory::with('author')->where('company_id',$company->id)->where('form_type','company')->select('id','comp_name','comp_logo','email','phone','profile_type','start_date','end_date','country','website','track_url','track_id','fax','address','active_flag','comp_sts','product_url','banner_image','banner_url','linkedin','twitter','facebook','created_at','updated_at','author_id','package')->get();
        $contact_details=CompanyHistory::with('author')->where('company_id',$company->id)->where('form_type','contact_details')->select('job_title','contact_email','contact_mobile','contact_name','email1','created_at','updated_at','author_id')->get();
        $billing_details=CompanyHistory::with('author')->where('company_id',$company->id)->where('form_type','billing')->select('id','billing_comp_name','billing_contact_person','billing_contact_number','billing_address','billing_country','billing_email','billing_value','vat_tax_gst','po_no','po_date','tax','created_at','updated_at','author_id')->get();
        return view('history.show', compact('company','company_history','contact_details','billing_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function historyShow(CompanyHistory $history){
        $model = 'history';
        $error = null;
        try {
            // Get information
            
            return view('history.modal_history_show', compact('history','error','model'));
        } catch (GroupNotFoundException $e) {
            // $error = trans('admin/groups/message.group_not_found', compact('id'));
            // return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

    }

    public function profilestatus(Request $request,$status)
    {
      
  
$companies = Company::select('id','comp_name', 'profile_type','active_flag','comp_sts')
                           ->where('active_flag', '=', $status)
                           ->get();

 //$companies = Company::where('active_flag', $status)->orderBy('id', 'desc')->get();

// print_r(mb_list_encodings());
//return mb_convert_encoding($companies, "UTF-8", "UTF-8");

 return $companies;

}

public function profilestage(Request $request,$stage)
    {

      
//return $stage='paid';
 //$companies = Company::where('profile_type','like',$stage)->orderBy('id', 'desc')->get();
        $companies = Company::select('id','comp_name', 'profile_type','active_flag','comp_sts')
                           ->where('profile_type', '=', $stage)
                           ->get();

 return $companies;

}

public function expire(Request $request)
{


      $request->from_date;
      $time = \Carbon\Carbon::now()->format('Y-m-d');

      $from=$request->from_date;;
      $to=$request->to_date;;

 //$companies = Company::where('to_date', '>=' , $time)->where('from_date', '<=' , $time)->get();

      $companies = Company::whereBetween('end_date', [$from,$to])->get();

 return $companies;
}

     public function billinghistoryShow(CompanyHistory $billing){
        $model = 'billing';
        $error = null;
        try {
            // Get information
            
            return view('history.modal_history_billing_show', compact('billing','error','model'));
        } catch (GroupNotFoundException $e) {
            // $error = trans('admin/groups/message.group_not_found', compact('id'));
            // return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Support;
use App\User;
use Auth;
use App\Whitepaper;
use App\Company;
use \Session;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $model;
   public function __construct(Support $model)
    {
        $this->model = $model;
        //$this->middleware('auth');
    }

     public function index(Request $request)
    {
       
       /* if($request->get('search')){
        $search = \Request::get('search'); 
        $whitepapers = Whitepaper::where('title', 'like', '%'.$search.'%')->paginate(20);
         }else{
            $whitepapers = Support::orderBy('id', 'desc')->paginate(10);
         }*/
          //$whitepapers = Support::orderBy('id', 'desc')->paginate(10);
         $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        $active = Support::orderBy('id', 'desc')->paginate(10);
        return view('Support.index', compact('active','companylist'));
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
    public function store(Request $request,$id)
    {
    
     $user=$email = Auth::user()->id;

    $supportinfo=new Support();
    $supportinfo->company_id=$request->input('company_id');
    $supportinfo->title=$request->input('title');
    $supportinfo->contact_date=$request->input('date');
    $supportinfo->comment=$request->input('description');
    $supportinfo->comment_sts=$request->input('comment_sts');
    $supportinfo->created_by=$user;

     $supportinfo->save();
    // $whitepapers = Support::orderBy('id', 'desc')->paginate(10);
        $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        $active = Whitepaper::where('active_flag', 1);
        return view('Support.index', compact('active','companylist'));
    }

 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function crmreport(Request $request)
    {

        //return $request->all();

         $cmpid=$request->input('company_id');
         $user=$email = Auth::user()->id;
        $whitepapers = Support::where('company_id',$cmpid)->where('created_by',$user)->orderBy('id', 'desc')->paginate(10);
        $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        $active = Whitepaper::where('active_flag', 1);
        return view('Support.index', compact('whitepapers', 'active','companylist'));
    }

    public function support(Request $request,$company)
    {

       

    $name = $request->input('comment');
    $user = Auth::user()->id;


    $supportinfo=new Support();
    $supportinfo->company_id=$company;
    $supportinfo->title=$request->input('title');
    $supportinfo->contact_date=$request->input('date');
    $supportinfo->comment=$name;
    $supportinfo->comment_sts='Active';
    $supportinfo->created_by=$user;

     $supportinfo->save();
    return $chatmesssage = Support::where('company_id',$company)->orderBy('id', 'desc')->first();
        $companylist = Company::where('active_flag',1)->pluck('comp_name','id');
        $active = Whitepaper::where('active_flag', 1);
        return view('Support.index', compact('active','companylist'));
    }
    public function getsupport(Request $request,$company)
    {

    $name = $request->input('comment');

//return $company=$request->input('company');
    $user=$email = Auth::user()->id;

    return $data = Support::where('company_id',$company)->orderBy('id', 'desc')->get();
        
    }
}

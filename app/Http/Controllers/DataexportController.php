<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
use Excel;
use App\DataConnecting;
use App\Getlistsubscribe;
use App\CompanyEnquiry;


class DataexportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = DB::select('SHOW TABLES');
        return view('dataexpo.index',compact('tables'));
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
       //Connect Data Base

         $db=$request->input('database');

         $dbuser=$request->input('databaseuser');

         $dbpassword=$request->input('databaseuserpassword');

         $form_type='mediapack-download';



       Config::set("database.connections.mysql1", [
            "driver"   => "mysql",
            "host"     => "localhost",
            "database" =>$db,
            "username" =>$dbuser,
            "password" =>$dbpassword
]);

        $db_ext = \DB::connection('mysql1');
        $tables = $db_ext->select('SHOW TABLES');
       
        //print_r($tables);
//exit;
         
       return view('import_export',compact('tables','db','dbuser','dbpassword'));

         
    // or just DB::connection()
        if (DB::connection()->getDatabaseName())
         {
         return 'Connected to the DB: ' . DB::connection()->getDatabaseName();
         }

         exit;

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
    public function exportdata(Request $request)
    {

    $tbl_info=$request->input("tableinfo");

    $from=$request->input("from_date");

    $to=$request->input("to_date");

    if(isset($tbl_info)){

      //header('Content-Type: text/csv; charset=utf-8');  
     // header('Content-Disposition: attachment; filename=data.csv');  
     // $output = fopen("php://output", "w");  

      //whereBetween('reservation_from', [$from, $to])
     
      $data = DB::table($tbl_info)->whereBetween('created_at', [$from, $to])->get()->toArray();


     foreach ($data as $trackinfo) {
        
        $urlinfoArray[] = $trackinfo;

        
    }
   $array = json_decode(json_encode($urlinfoArray), True); 

   return Excel::create($tbl_info, function($excel) use ($array) {

   $excel->sheet('trackReport', function($sheet) use ($array)
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


     public function promotionLeads()
   {



    $promotiondata=DB::table('flatpages')->select('type')->distinct('type')->get();

    $forms = DB::table('forms')->whereIn('type',['registration','post-requirement','contactus','mediapack-download','newsletter-signup','OurServices'])->select('type')->distinct('type')->get();
    $getlisted = Getlistsubscribe::select('form_type')->distinct('form_type')->get();
        return view('promotions.promotion',compact('promotiondata','forms','getlisted'));



   }

   public function promotionleadslist($promotion)
   {

  $leadsinfo=DB::table('flatpages')->select('id','name','email','title','company','country','type','phone','created_at')->where('type',$promotion)->orderBy('id', 'desc')->get();

 return view('promotions.leads',compact('leadsinfo'));

   }

   public function promotionformleadslist($promotion)
   {

    $leadsinfo=DB::table('forms')->select('id','name','email','title','company','country','type','phone','created_at')->where('type',$promotion)->orderBy('id', 'desc')->get();

      return view('promotions.leads',compact('leadsinfo'));

  }

  public function promotiongetlistleadslist($promotion)
   {

    $leadsinfo=DB::table('forms')->select('id','name','email','title','company','country','type','phone','created_at')->where('type','get-listed/'.$promotion)->orderBy('id', 'desc')->get();

      return view('promotions.leads',compact('leadsinfo'));

  }
   public function promotiongetlistleadslistnew($promotion)
   {
   $getlist_leadsinfo=Getlistsubscribe::select('id','firstname','lastname','email','company','country','type','form_type','phone','created_at')->where('form_type',$promotion)->orderBy('id', 'desc')->get();

      return view('promotions.getlisted-leads',compact('getlist_leadsinfo'));

  }
  public function productEnquires(Request $request)
  {
    $search = $request->get('search');
    $enquires = DB::table('company_enquiries')
                    ->select(DB::raw('count(*) as total,product_id,company_id,prod_name,page'))
                    ->when(!empty($search),function($query) use($search){
                        $query->where('prod_name','like', '%'.$search.'%');
                    })->WhereNotNull('product_id')
                    ->groupBy(['product_id', 'company_id','prod_name','page'])
                    ->paginate(10);
    return view('promotions.product-enquires',compact('enquires'));
  }
  public function productEnquiresView($id)
  {
    $leadsinfo = DB::table('company_enquiries')->where('product_id',$id)->get();
    return view('promotions.product-enquires-view',compact('leadsinfo'));
  }

}

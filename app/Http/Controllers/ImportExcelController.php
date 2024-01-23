<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use \Excel;
use App\User;
use Auth;
use App\Company;
use \Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\CompanyProfile;

class ImportExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
     $data = DB::table('companies')->where('profile_type','FP')->orderBy('id', 'DESC')->get();
//      foreach ($data as $key => $value) {
// 		 	CompanyProfile::create([
// 		 	    'company_id'=>$value->id,
// 		 	    'title'=>$value->comp_name,
// 		 	    'url'=>str_slug($value->comp_name),
// 		 	    'profile_type'=>'FP',
// 		 	    'active_flag'=>'0'
// 		 	 ]);
// 		 }
     return view('companies.import_excel', compact('data'));
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

    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

      $path = $request->file('select_file')->getRealPath();

      $data = \Excel::load($path)->get();
      $role='6';

     if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $value)
      {



        $insert_data[] = array(

        /*'email'=> $value['email'],*/
        'featured_company'=> $value['company'], 
        'title'=> $value['product'],    
        /*'contact_name'=>$value['contact'], 
        'country'=>$value['country'],  
        'start_date'=>'2021-03-17',
        'end_date'=>'2022-03-17',   */
        'profile_type'=>'FP',
        'active_flag'=>'0',
        'author_id'=> $request->user()->id
         );


      }

      

     /*   $companyp = new CompanyProfile();

       // $companyp->title = ucfirst($request->input("title"));

       return  $comp = DB::table('companies_featured')->latest('id')->first();

        $comp->companyprofile()->save($companyp);*/


      if(!empty($insert_data))
      {
       DB::table('products')->insert($insert_data);
       
     /*for($i=0;$i<count($insert_data);$i++)
        {
        $user = new User();
        $user->name =$insert_data[$i]['comp_name'];
        $user->email =$insert_data[$i]['email'];
        $user->password = bcrypt('123456');
        $user->active_flag = 1;
        $user->save();
        $user->attachRole($role);

        //  $data = [
        //     'name'=>$insert_data[$i]['comp_name'],
        //     'email'=>$insert_data[$i]['email'],
        //     'password'=>bcrypt('123456'),
        //   ];
        //   DB::table('new-users')->insert($data);

       }*/
        // Mail::send('emails.registration.admin', $data, function($message) use ($data) {
  //       $message->to('omplenquiry@ochre-media.com');   
  //       $message->subject('New User Signed Up for PAPT!');
  //       });

 }
  
     return back()->with('success', 'Excel Data Imported successfully.');
    }
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Filesystem\Filesystem;
use Excel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Category;
use App\CompanyProfile;
use App\Product;
use App\CompanyCatalog;
use App\CompanyWhitePaper;
use App\CompanyVideo;
use App\CompanyPressrealese;
use App\CompanyProject;
use Auth;

class MoveDataController extends Controller
{
      public function index(Request $request)
    {        

            if($request->get('search')){
        $search = \Request::get('search'); //<-- we use global request to get the param of URI
        $companies = Company::where('comp_name', 'like', '%'.$search.'%')->paginate(20);
         }else{
            //$companies = Company::orderBy('id', 'desc')->paginate(10);
            $products1 =  \DB::table('temp_products')->pluck('company_id')->unique();       
        $press1 =  \DB::table('temp_company_pressrealese')->pluck('company_id')->unique();      
        $catalogs1 =  \DB::table('temp_company_catalogs')->pluck('company_id')->unique();
        $videos1 =  \DB::table('temp_company_videos')->pluck('company_id')->unique();
        $whitepapers1 =  \DB::table('temp_company_whitepapers')->pluck('company_id')->unique();
        
         $list = array_merge($press1->toArray(),$products1->toArray(),$videos1->toArray(),$whitepapers1->toArray());
         $final= (collect($list)->unique()->all()); 
            $companies =  Company::select('id','comp_name')->whereIn('id',$final)->paginate(10);
         }
        $active = Company::where('active_flag', 1);
        
        
         
         //$companies =  Company::select('id','comp_name')->whereIn('id',$final)->get();

        return view('companyUploads.index',compact('companies'));
    }

//Move single profile to live
    public function moveData(Company $company){
      
      $result = $this->storeData($company->id);
      if($result == true){

       $company->active_flag = 1;
       $company->profile_type = 'free';
       $company->save();

       $company_info = CompanyProfile::where('company_id',$company->id)->first();
       $company_info->active_flag = 1;
       $company_info->save();
       return 'successfully moved';
     }
   }



public function profilelive(Company $company,Request $request){

    if($request->hasFile('sample_file')){
       $path = $request->file('sample_file')->getRealPath();
       $data = Excel::selectSheets('profiles')->load($path)->get(); 
       if($data->count()){

          foreach ($data as $key => $val) {
            $slug_data=substr($val->url,53);
            
            $slug=$slug_data;

            $company_info=CompanyProfile::where('url',$slug)->first();
          
            $company=$company_info->company_id;

            $result =$this->storeData($company);
        }
        if($result == true){
         $company = Company::find($company_info->company_id);
         $company->active_flag = 1;
         $company->profile_type = 'free';
         $company->save();

         $company_info->active_flag = 1;
         $company_info->save();
            return 'successfully moved';
        }
    }
}
}


//  public function profilelive(Company $company,Request $request){
//     if($request->hasFile('sample_file')){
//      $path = $request->file('sample_file')->getRealPath();

//      $data = \Excel::load($path)->get();
//      if($data->count()){

//       foreach ($data as $key => $value) {

//           foreach ($value as $key => $val) {

//            $slug_data=substr("$val",65);

//            //  $slug=rtrim($slug_data,2);

//            $slug=substr($slug_data, 0, -2);

//            $company_info=CompanyProfile::where('url',$slug)->first();
           
//            $company=$company_info->company_id;

//            $result =$this->storeData($company);
          
//        }
//         if($result == true){
//             return 'successfully moved';
//            }
//    }
// }
// }
// }



//Storing
public function storeData($company_id){
    $company = Company::find($company_id); 

    $products = Product::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($products->count() != 0 ){
        foreach ($products as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
            $category = Category::find($value->category_id);
            $value->categories()->sync($category);
        }
    }

    $catalogs = CompanyCatalog::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($catalogs->count() != 0 ){
        foreach ($catalogs as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
        }
    }

    $whitePapers = CompanyWhitePaper::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($whitePapers->count() != 0 ){
        foreach ($whitePapers as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
        }
    }

    $videos = CompanyVideo::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($videos->count() != 0 ){
        foreach ($videos as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
        }
    }

    $pressrealeses = CompanyPressrealese::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($pressrealeses->count() != 0 ){
        foreach ($pressrealeses as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
        }
    }
    $projects = CompanyProject::where('company_id',$company_id)->where('active_flag',0)->where('stage',0)->get();

    if($projects->count() != 0 ){
        foreach ($projects as $key => $value) {
            $value->active_flag = 1;
            $value->stage = 1;
            $value->save();
        }
    }
    return true;
}


public function profiletyp(Request $request)
{

 if($request->hasFile('sample_file')){
    $path = $request->file('sample_file')->getRealPath();

    $data = \Excel::load($path)->get();

    if($data->count()){
         foreach ($data as $key => $value) {
            echo $cmp_name=$value['comp_name'];
            echo "<br>";
            echo $profiletype=$value['status'];

            $company = Company::where('comp_name',$cmp_name)->first();
            if($company){
                $company->comp_sts = $value['status'];
                $company->save();
            }
        }
        return ' success' ;

    }
  }
}

    public function profileliveview()
    {
          $msg = [
            'title'=>'Bulk Profiles Move to live - Based on URLs',
            'info'=>'This is the module for make test profiles as live.',
            'note'=>'Kindly upload xlxs file contains complete test urls of the profiles. sheet name must be "profiles" and column herader title must be "url"',
            'post_route'=>'moveprofile'
        ];
        return view('profilelive.create',compact('msg'));  
    }

}

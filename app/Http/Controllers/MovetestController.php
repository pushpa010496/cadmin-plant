<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\CompanyProfile;
use App\Product;
use App\CompanyWhitepaper;
use App\CompanyPressrealese;
use App\CompanyCatalog;
use App\CompanyVideo;
use Illuminate\Support\Facades\Input;
use DB;
use Excel;

class MovetestController extends Controller
{
    
    // Profiles moved to live from test
    public function testToLive(Request $request)
    {
       if(\Request::isMethod('post')){
          if($request->hasFile('sample_file')){
           $path = $request->file('sample_file')->getRealPath();
           $dataSheet = Excel::selectSheets('profiles')->load($path)->get();

                if($dataSheet->count()){
                   $flag1 = 0;
                   $flag2 = 1; 
                    foreach ($dataSheet as $key => $company) {
                        $data=Company::Where('comp_name', 'like', '%' . $company->name . '%')->first();

                        if (empty($data)) {
                            return $company;
                        }

                        $this->status($flag1,$flag2,$data->id);
                        $data->active_flag = 1;
                        $data->save();

                        $profile=CompanyProfile::Where('company_id', $data->id)->first();
                        $profile->active_flag = 1;
                        $profile->save();
                    }
                     return back()->with('success', 'Data successfully moved....');
                }    
            }
        }else{

            $msg = [
                'title'=>'Bulk Profiles Move to live - based on Comapny names',
                'info'=>'This is the module for make profiles as live.',
                'note'=>'Kindly upload xlxs file contains profile names. sheet name must be "profiles" and column herader title must be "name"',
                'post_route'=>'testtolive'
            ];
           return view('profilelive.create',compact('msg'));
         }  
    }

    //Profiles moved to test from live
    public function liveToTest(Request $request)
    {
      if(\Request::isMethod('post')){
          if($request->hasFile('sample_file')){
           $path = $request->file('sample_file')->getRealPath();
           $dataSheet = Excel::selectSheets('profiles')->load($path)->get();

                if($dataSheet->count()){
                   $flag1 = 1;
                   $flag2 = 0; 
                    foreach ($dataSheet as $key => $company) {
                        $data=Company::Where('comp_name', 'like', '%' . $company->name . '%')->first();

                        if (empty($data)) {
                            return $company;
                        }

                        $this->status($flag1,$flag2,$data->id);
                        $data->active_flag = 0;
                        $data->save();

                        $profile=CompanyProfile::Where('company_id', $data->id)->first();
                        $profile->active_flag = 0;
                        $profile->save();
                    }                     
                     return back()->with( 'success', 'Data successfully moved....' );
                }    
            }
        }else{

            $msg = [
                'title'=>'Bulk Profiles Move to Test from Live - based on Comapny names',
                'info'=>'This is the module for Move profiles from live to test.',
                'note'=>'Kindly upload xlxs file contains profile names. sheet name must be "profiles" and column herader title must be "name"',
                'post_route'=>'livetotest'
            ];
           return view('profilelive.create',compact('msg'));
         }  
    }

    //Change status to live or test
    public function status($flag1,$flag2,$id)
    {       
        ///////////////////////////////////////////////
        $products = Product::where('company_id',$id)->where('active_flag', $flag1)->where('stage', $flag1)->get();

        if($products->count() != 0 ){
            foreach ($products as $key => $value) {
                $value->active_flag = $flag2;
                $value->stage = $flag2;
                $value->save();
            }
        }

        $catalogs = CompanyCatalog::where('company_id',$id)->where('active_flag', $flag1)->where('stage', $flag1)->get();

        if($catalogs->count() != 0 ){
            foreach ($catalogs as $key => $value) {
                $value->active_flag = $flag2;
                $value->stage = $flag2;
                $value->save();
            }
        }

        $whitePapers = CompanyWhitePaper::where('company_id',$id)->where('active_flag', $flag1)->where('stage', $flag1)->get();

        if($whitePapers->count() != 0 ){
            foreach ($whitePapers as $key => $value) {
                $value->active_flag = $flag2;
                $value->stage = $flag2;
                $value->save();
            }
        }

        $videos = CompanyVideo::where('company_id',$id)->where('active_flag', $flag1)->where('stage', $flag1)->get();

        if($videos->count() != 0 ){
            foreach ($videos as $key => $value) {
                $value->active_flag = $flag2;
                $value->stage = $flag2;
                $value->save();
            }
        }

        $pressrealeses = CompanyPressrealese::where('company_id',$id)->where('active_flag', $flag1)->where('stage', $flag1)->get();

        if($pressrealeses->count() != 0 ){
            foreach ($pressrealeses as $key => $value) {
                $value->active_flag = $flag2;
                $value->stage = $flag2;
                $value->save();
            }
        }
        ////////////////////////////////////////////////
        return true;
    }

}
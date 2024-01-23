<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Company;
use App\CompanyProfile;
use App\Product;
use App\CompanyPressrealese;
use App\CompanyWhitepaper;
use App\CompanyCatalog;
use App\CompanyVideo;
use \Session;
use Carbon\Carbon;
use App\Mail\CompanyInactive;
use Illuminate\Support\Facades\Mail;
use App\Slider;
use App\Banner;

class InactiveProfilesController extends Controller
{
   public function InactivePages(){

   	return view('inactive.pages');
   }
    public function Inactivecompanies(Request $request){

    	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$companies = Company::where('comp_name', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$companies = Company::orderBy('id', 'desc')->where('active_flag', 0)->paginate(10);
		 }
		$active = Company::where('active_flag', 0);
		return view('companies.index', compact('companies', 'active'));
   	
   }
    public function InactiveProfiles(Request $request){

   	if($request->get('search')){
		$search = \Request::get('search');
 			$companyprofile = CompanyProfile::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companyprofile = CompanyProfile::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = CompanyProfile::where('active_flag', 1);
		return view('companyprofile.index', compact('companyprofile', 'active'));
   }
   public function InactiveProducts(Request $request){

   	if($request->get('search')){
		$search = \Request::get('search');
 			$products = Product::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$products = Product::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = Product::where('active_flag', 1);
		return view('products.index', compact('products', 'active'));
   }
   public function InactivePressreleases(Request $request){

   	if($request->get('search')){
		$search = \Request::get('search');
 			$companypressrealeses = CompanyPressrealese::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companypressrealeses = CompanyPressrealese::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = CompanyPressrealese::where('active_flag', 1);
		return view('companypressrealeses.index', compact('companypressrealeses', 'active'));
   }
   public function InactiveWhitepapers(Request $request){

   	if($request->get('search')){
		$search = \Request::get('search');
 			$companywhitepapers = CompanyWhitepaper::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companywhitepapers = CompanyWhitepaper::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = CompanyWhitepaper::where('active_flag', 1);
		return view('companywhitepapers.index', compact('companywhitepapers', 'active'));
   }
   public function InactiveCatlogs(Request $request){
	if($request->get('search')){
		$search = \Request::get('search');
 			$companycatalogs = CompanyCatalog::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companycatalogs = CompanyCatalog::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = CompanyCatalog::where('active_flag', 1);
		return view('companycatalogs.index', compact('companycatalogs', 'active'));
   }
   public function InactiveVideos(Request $request){

   if($request->get('search')){
		$search = \Request::get('search');
 			$companyvideos = CompanyVideo::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->where('title', 'like', '%'.$search.'%')
	 		->paginate(20);
   		 }else{
   			$companyvideos = CompanyVideo::orderBy('id', 'desc')->where('active_flag',0)->paginate(10);
		 }
 	
		$active = CompanyVideo::where('active_flag', 1);
		return view('companyvideos.index', compact('companyvideos', 'active'));
   }

    //  public function companyInactive(){
    //     $date = new \DateTime();
    //     $from = $date->modify('-80 days')->format('Y-m-d H:i:s');
    //     $companies =   Company::whereDate('start_date', '>=', $from)->get();
    //     $data = $companies;
    //     Mail::to('nagaraj@ochre-media.com')
    //     ->send(new CompanyInactive($data));
        
    //     return 'Mail has been send successfully';
    // }

   public function companyInactive(){
     
     //Banner expiring
      $time = \Carbon\Carbon::now()->modify('+1 days')->format('Y-m-d');
      $expire_soon =  Banner::where('active_flag','=', 1)->whereDate('to_date', '=' , $time)->where('from_date', '<=' , $time)->get();
      $expire_today =  Banner::where('active_flag','=', 1)->whereDate('to_date', '=' , date('Y-m-d'))->where('from_date', '<=' , $time)->get();

      if(count($expire_soon) or count($expire_today)){
           $data = [                     
            'data1'=> $expire_soon,
            'data2'=>$expire_today
          ];

          Mail::send('emails.banner_expire', $data, function($message) use ($data) {
            $message->to('omplenquiry@ochre-media.com');
            $message->subject('Banners Update - PAT');

          });
      }

        $date = new \DateTime();
        $from = $date->modify('-80 days')->format('Y-m-d H:i:s');
        $data = Company::whereDate('start_date', '>=', $from)->get();
        if(count($data)){              
          Mail::to('nagaraj@ochre-media.com')
          ->send(new CompanyInactive($data));          
        }
        
        return 'Success';
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\democompany\Company;
use App\democompany\CompanyProfile;
use App\democompany\Product;
use App\democompany\CompanyCatalog;
use App\democompany\CompanyPressrealese;
use App\democompany\CompanyWhitepaper;
use App\democompany\CompanyVideo;
use \Session;
use \DB;
use \Mail;
use App\SeoCompany;
use App\SeoPage;
use App\Page;
use App\Country;
use SEOMeta;
use OpenGraph;
use Twitter;
## or
use SEO;


class DemocompanyController extends Controller
{
   protected $model;
    public function __construct(Company $model)
    {
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

        return view('democompany.list',compact('companies'));
    }

    public function profile($companyurl)
    {
       /* $seo = SeoCompany:: whereHas('seocompanypro' , function($query) use($companyurl) {
            $query->where('url', 'like', $companyurl);})->where('active_flag',1)->where('pages','company_profile')->get();*/
             $seo = CompanyProfile::where('url',$companyurl)->where('active_flag',1)->get();

             if($seo->count() ==0){
                return view('errors.404');
            }
    
      $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');
    	// $countries = DB::table('countries')->select('country_name')->get();
    	$companyprofile = CompanyProfile::with('pproduct')->where('url',$companyurl)->first();

         $cid = CompanyProfile::where('url',$companyurl)->get();
 
       $company = $cid;
        // $countries = DB::table('countries')->select('country_name')->get();
        
       // $companyprofile = Product::where('company_id',$cid[0]->company_id)->get();

    	//print_r($companyprofile);exit();
        return view('democompany.profile',compact('companyprofile','countries','company'));
    }
    public function product($companyurl)
    {

        /*$seo = SeoCompany:: whereHas('seocompanypro' , function($query) use($companyurl) {
            $query->where('url', 'like', $companyurl);})->where('active_flag',1)->where('pages','products')->get();*/
             $companyprofile = CompanyProfile::where('url',$companyurl)->first();
             if($companyprofile->count() ==0){
                return view('errors.404');
            }
       
        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');
        $cid = CompanyProfile::where('url',$companyurl)->first();
 
       $company = $cid;
    	// $countries = DB::table('countries')->select('country_name')->get();
        
       $products = Product::where('company_id',$cid->company_id)->orderBy('id','desc')->get();

         
    	// print_r($companyprofile);exit();
        return view('democompany.product',compact('companyprofile','countries','company','products'));
    }
    public function productview($companyurl,$producturl)
    {

        $countries = Country::all()->pluck('country_name', 'id')->prepend('Select a Country', '');
        $companyprofile = CompanyProfile::where('url',$companyurl)->first();
    	 if($companyprofile->count() ==0){
                return view('errors.404');
            }
     

     	 $prods = Product::where('company_id',@$companyprofile->company_id)->where('url',$producturl)->get();

      

        return view('democompany.productview',compact('companyprofile','countries','prods','company'));
    }
    public function pressrelease($companyurl)
    {
        /*$seo = SeoCompany:: whereHas('seocompanypro' , function($query) use($companyurl) {
            $query->where('url', 'like', $companyurl);})->where('active_flag',1)->where('pages','pressrelease')->get();*/
            $companyprofile =CompanyProfile::where('url',$companyurl)->first();
      
        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');
          $cid = CompanyProfile::where('url',$companyurl)->where('active_flag',0)->get();
       
        return view('democompany.pressrelease',compact('companyprofile','countries','company'));
    }
    public function catalogue($companyurl)
    {

        $companyprofile = CompanyProfile::where('url',$companyurl)->first();
        if($companyprofile->count() ==0){
            return view('errors.404');
        }

        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');

        $cid = CompanyProfile::where('url',$companyurl)->first();
        $company = $cid;

        return view('democompany.catalogue',compact('companyprofile','countries','company'));
    }
    public function whitepaper($companyurl)
    {
      
        $companyprofile = CompanyProfile::where('url',$companyurl)->first();
        if($companyprofile->count() ==0){
            return view('errors.404');
        }

        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');

        $cid = CompanyProfile::where('url',$companyurl)->get();

        $company = $cid;    
        return view('democompany.whitepaper',compact('companyprofile','countries','company'));
    }
    public function video($companyurl)
    {
       
        $companyprofile = CompanyProfile::with('pvideo')->where('url',$companyurl)->first();
         if($companyprofile->count() ==0){
                return view('errors.404');
            }
       
        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');
        
        
           $cid = CompanyProfile::where('url',$companyurl)->where('active_flag',0)->get();
 
       $company = $cid;
     
      	

        return view('democompany.video',compact('companyprofile','countries','company'));
    }


    /* Demo Url Work */

public function productdemo($companyurl)
    {
        /*$seo = SeoCompany:: whereHas('seocompanypro' , function($query) use($companyurl) {
            $query->where('url', 'like', $companyurl);})->where('active_flag',1)->where('pages','products')->get();*/
            $seo = CompanyProfile::where('url',$companyurl)->where('active_flag',0)->get();
             if($seo->count() ==0){
                return view('errors.404');
            }
             foreach ($seo as $value) {
            SEOMeta::setTitle($value->company->comp_name.' - Industrial Manufacturer Product Line');
            SEOMeta::setDescription('All Products from the Industrial Manufacturer'. $value->company->comp_name. 'Get detailed techical specifications, industrial applications & product reviews.');
            SEOMeta::addMeta('products:published_time', $value->created_at->toW3CString(), 'property');
            SEOMeta::addKeyword($value->meta_keywords);
            OpenGraph::setDescription('All Products from the Industrial Manufacturer'. $value->company->comp_name. 'Get detailed techical specifications, industrial applications & product reviews.');
            OpenGraph::setTitle($value->company->comp_name.' - Industrial Manufacturer Product Line');
            OpenGraph::setUrl(url()->current());
            SEOMeta::setCanonical(url()->current());
            OpenGraph::addProperty('keyword', $value->og_keywords);
            OpenGraph::addProperty('type', 'products');
            OpenGraph::addProperty('locale', 'en_GB');
            //OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage([$value->og_image, 'size' => 300]);
        }
        $countries = Country::all()->pluck('country_name', 'country_name')->prepend('Select Country', '');
        // $countries = DB::table('countries')->select('country_name')->get();
        $companyprofile = CompanyProfile::with('pproduct')->where('url',$companyurl)->where('active_flag',0)->get();

        //print_r($companyprofile);exit();
        return view('democompany.product',compact('companyprofile','countries'));
    }





    /* End Demo Url work */
}

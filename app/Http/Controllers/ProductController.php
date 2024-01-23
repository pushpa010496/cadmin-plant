<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use SEOMeta;
use App\SeoPage;
use OpenGraph;
use Twitter;
use App\CompanyProfile;
use Illuminate\Support\Str;
use App\Product;
use App\Company;

use \Session;
use App\Category;
use File;
use App\SearchKeyword;
use App\ProductLandingPage;
use Artesaos\SEOTools\Facades\TwitterCard;

class ProductController extends Controller
{
	protected $model;
	public function __construct(Product $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    
    public function index(Request $request)
    {
       	if($request->get('search'))
       	{
		$search = \Request::get('search');
 			$products = Product::with('company')
                       ->whereHas('company', function($query) use($search) {$query->where('comp_name', 'like', '%'.$search.'%');})
                       ->orWhere('title', 'like', '%'.$search.'%')
                       ->paginate(20);
	 		$products->appends(['search' => $search]);
   		 }
   		 else
   		 {
   			$products = Product::select('id','title','url','company_id','company_profile_id')->where('active_flag',1)->orderBy('id', 'desc')->paginate(20);
		 }
 	
		$active = Product::select('id','title','url','company_id','company_profile_id')->where('active_flag', 1);
		return view('products.index', compact('products', 'active'));
    }

    public function create()
	{
		/*$cat = getcat(22); 
		print_r($cat);die;*/
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('products.create',compact('companylist'));		
	}
	public function store(Request $request, User $user)
	{
		$comp = $request->input("company_id");
		$categ = $request->input("subcategory_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$category = Category::where('id',$categ)->select('name')->first();
		//print_r($company->comp_name);die;
		$companyc = new Product();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		//print_r(str_slug($company->comp_name)); die;
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
			'category_id' => 'required',
            'small_image' => 'required',           
            'big_image' => 'required',           
            'tech_spec_pdf' => 'max:20000'            
        ]);
        if($request->file('small_image')){
        $small_imageName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_image')->getClientOriginalName());
        request()->small_image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $small_imageName);
		$companyc->small_image = $small_imageName;	
	    }
	    if($request->file('big_image')){
        $big_imageName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_image')->getClientOriginalName());
        request()->big_image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $big_imageName);
		$companyc->big_image = $big_imageName;	
	    }
	    if($request->file('tech_spec_pdf')){
        $tech_spec_pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('tech_spec_pdf')->getClientOriginalName());
        request()->tech_spec_pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $tech_spec_pdfName);
		$companyc->tech_spec_pdf = $tech_spec_pdfName;	
	    }
		
		$companyc->title = $request->input("title");
		$companyc->meta_keywords = $request->input("title");
		$companyc->meta_title = ''.$request->input("title"). ' | '.@$category->name .' | '.@$company->comp_name.'';		
		$companyc->og_title = ''.$request->input("title"). ' | '.@$company->comp_name .' | '.@$category->name.'';		
		$companyc->meta_description = ''.@$category->name. ' suppliers and manufacturers of the '.@$company->comp_name .' provide high quality products such as '.$request->input("title").'';
		$companyc->og_description = ''.@$category->name. ' suppliers and manufacturers of the '.@$company->comp_name .' provide high quality products such as '.$request->input("title").'';;
		$companyc->og_keywords = $request->input("title");
		$companyc->og_image = $companyc->og_image = config('app.url').'products/'.$big_imageName;

		$companyc->title_tag = ucfirst($request->input("title_tag"));
		//$companyc->category_id = $request->input("category_id");
		$companyc->category_id = $request->input("subcategory_id");
		$companyc->alt_tag = ucfirst($request->input("alt_tag"));
		$companyc->description = ucfirst($request->input("description"));
		$companyc->url = str_slug($request->input("url"));
		$companyc->googleplus = $request->input("googleplus");
		$companyc->linkedin = $request->input("linkedin");
		$companyc->facebook = $request->input("facebook");
		$companyc->twitter = $request->input("twitter");
		$companyc->keyword1 = $request->input("keyword1");
		$companyc->keyword2 = $request->input("keyword2");
		$companyc->keyword3 = $request->input("keyword3");
		$companyc->keyword4 = $request->input("keyword4");
		$companyc->keyword5 = $request->input("keyword5");
		$companyc->active_flag = $request->input("active_flag");
		$companyc->stage = $request->stage;
		$companyc->author_id = $request->user()->id;
		$companyc->type = 'admin';		
		$companyc->display_order = $request->input("display_order");
		$comp = Company::find($request->input("company_id"));

		$comp->companyproduct()->save($companyc);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pproduct()->save($companyc);

		$category = Category::find($request->input("subcategory_id"));
		//$category = Category::find($request->input("category_id"));
		$companyc->categories()->save($category);

		return redirect()->route('products.index');
	}
	public function show(Product $product)
	{
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$product->company_id)->select('url')->first();
		return view('products.show', compact('product','profile'));
	}
	public function edit(Product $product){   

		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		$profilelist = CompanyProfile::where('company_id',$product->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$product->company_id)->select('url')->first();
		//print_r($profile->url); die;
        return view('products.edit', compact('product','companylist','profilelist','profile'));
	}
	public function update(Request $request, Product $product, User $user){
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
        if($request->company_id != $product->company->id){		
			$oldPath = public_path('suppliers').'/'.str_slug($product->company->comp_name).'/products/';
			$newPath = public_path('suppliers').'/'.str_slug($company->comp_name).'/products/';		
			//small image
			if($product->small_image){
				if (copy($oldPath.$product->small_image, $newPath.$product->small_image)) {
					\File::delete($oldPath.$product->small_image);
				}
			}
			//big image
			if($product->big_image){
				if (copy($oldPath.$product->big_image, $newPath.$product->big_image)) {
					\File::delete($oldPath.$product->big_image);
				}
			}
			//big image
			if($product->tech_spec_pdf){
				if (copy($oldPath.$product->tech_spec_pdf, $newPath.$product->tech_spec_pdf)) {
					\File::delete($oldPath.$product->tech_spec_pdf);
				}
			}
		}

		$path = public_path('suppliers').'/'.str_slug($company->comp_name).'/products';
		if($request->file('small_image')){
			$small_imageName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_image')->getClientOriginalName());
			if(request()->small_image->move($path, $small_imageName)){	        		
				if(File::exists($path.'/'.$product->small_image)){	        		
					\File::delete($path.'/'.$product->small_image);        	        		
				}
			}
        // $small_imageName = preg_replace('/\s+/','-',time().'-small-'.$request->file('small_image')->getClientOriginalName());
        // request()->small_image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $small_imageName);
			$product->small_image = $small_imageName;	
		}
		if($request->file('big_image')){
			$big_imageName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_image')->getClientOriginalName());
			if(request()->big_image->move($path, $big_imageName)){
				if(File::exists($path.'/'.$product->big_image)){	        		
					\File::delete($path.'/'.$product->big_image);        	        		
				}

			}
        // $big_imageName = preg_replace('/\s+/','-',time().'-big-'.$request->file('big_image')->getClientOriginalName());
        // request()->big_image->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $big_imageName);
			$product->big_image = $big_imageName;	
		}
		if($request->file('tech_spec_pdf')){
			$tech_spec_pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('tech_spec_pdf')->getClientOriginalName());
			if(request()->tech_spec_pdf->move($path, $tech_spec_pdfName)){
				if(File::exists($path.'/'.$product->tech_spec_pdf)){	        		
					\File::delete($path.'/'.$product->tech_spec_pdf);        	        		
				}

			}
        // $tech_spec_pdfName = preg_replace('/\s+/','-',time().'-'.$request->file('tech_spec_pdf')->getClientOriginalName());
        // request()->tech_spec_pdf->move(public_path('suppliers').'/'.str_slug($company->comp_name).'/products', $tech_spec_pdfName);
			$product->tech_spec_pdf = $tech_spec_pdfName;	
		}
		
		$product->title = $request->input("title");		
		$product->title_tag = $request->input("title_tag");
		$product->category_id = $request->input("category_id");
		//$product->subcategory_id = $request->input("subcategory_id");
		$product->alt_tag = ucfirst($request->input("alt_tag"));
		$product->description = ucfirst($request->input("description"));
		$product->url = str_slug($request->input("url"));
		$product->googleplus = $request->input("googleplus");
		$product->linkedin = $request->input("linkedin");
		$product->facebook = $request->input("facebook");
		$product->twitter = $request->input("twitter");
		$product->keyword1 = $request->input("keyword1");
		$product->keyword2 = $request->input("keyword2");
		$product->keyword3 = $request->input("keyword3");
		$product->keyword4 = $request->input("keyword4");
		$product->keyword5 = $request->input("keyword5");
		$product->active_flag = $request->input("active_flag");
		$product->stage = $request->stage;
		$product->author_id = $request->user()->id;
		$product->display_order = $request->input("display_order");
				
		$comp = Company::find($request->input("company_id"));
		$comp->companyproduct()->save($product);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pproduct()->save($product);

		$category = Category::find($request->input("category_id"));
		$product->categories()->sync($category);

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='products/$product->slug'>" . $product->title . "</a>\" was Updated.");

		return redirect()->route('products.index');
	}



	public function destroy(Product $products,$id){
		$products = Product::findOrFail($id);
		$products->active_flag = 0;
		$products->stage = 0;
		$products->save();


		$category = Category::find($products->category_id);
		$products->categories()->detach($category);

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $products->title . ' was De-Activated.');

		return redirect()->route('products.index');
	}
	public function reactivate(Product $products,$id){
		$products = Product::findOrFail($id);
		$products->active_flag = 1;
		$products->stage = 1;
		$products->save();

		$category = Category::find($products->category_id);
		$products->categories()->sync($category);
		
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $products->title . ' was Re-Activated.');

		return redirect()->route('products.index');
	}
	public function selectAjax(Request $request){

    	if($request){
    		$profiles = CompanyProfile::where('company_id',$request->company_id)->where('active_flag',1)->pluck("title","id")->all();

    		$data = view('ajax-select',compact('profiles'))->render();
    		return response()->json(['options'=>$data]);
       	}
   	}
   	public function metatag(Request $request, $id){
   		$meta = Product::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("meta_title");
		$meta->og_description = $request->input("meta_description");
		$meta->og_keywords = $request->input("meta_keywords");
		$meta->og_image = $request->input("og_image");
		$meta->og_video = $request->input("og_video");
		$meta->meta_region = $request->input("meta_region");
		$meta->meta_position = $request->input("meta_position");
		$meta->meta_icbm = $request->input("meta_icbm");
		$meta->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->back();
	}
	public function keywordmetatag(Request $request, $id){
   		$meta = SearchKeyword::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("meta_title");
		$meta->og_description = $request->input("meta_description");
		$meta->og_keywords = $request->input("meta_keywords");
		$meta->og_image = $request->input("og_image");
		$meta->og_video = $request->input("og_video");
		$meta->meta_region = $request->input("meta_region");
		$meta->meta_position = $request->input("meta_position");
		$meta->meta_icbm = $request->input("meta_icbm");
		$meta->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->back();
	}
	public function keywords(Request $request)
	{
	    if($request->get('search')){
		   $search = $request->get('search');
 			$keywords = SearchKeyword::where('keyword', 'like', '%'.$search.'%')
                    	 		->where('no_products',NULL)
                    	 		->paginate(20);
	 	     $keywords->appends(['search'=>$search]);
   		 }else{
   		      $keywords = SearchKeyword::where('no_products',NULL)->paginate(20);
   		 }
   		 
   	      return view('products.keywords',compact('keywords'));
	}
	public function statusKeywords(Request $request)
	{
	    if($request->get('status') == 1 || $request->get('status')==0){
		   $status = $request->get('status');
 			$keywords = SearchKeyword::where('status', $status)
                    	 		->where('no_products',NULL)
                    	 		->paginate(20);
	 	     $keywords->appends(['status'=>$status]);
   		 }else{
   		      $keywords = SearchKeyword::where('no_products',NULL)->paginate(20);
   		 }
   		 
   	      return view('products.keywords',compact('keywords'));
	}
	public function noKeywords(Request $request)
	{

      $keywords = SearchKeyword::where('no_products',0)->paginate(20);
      return view('products.no-keywords',compact('keywords'));
	}
	public function keywordReactivate(Request $request, $id)
	{
        $keyword = SearchKeyword::find($id);
        $keyword->update(['status'=>'1','meta_title'=>$keyword->keyword,'meta_keywords'=>$keyword->keyword,'meta_description'=>$keyword->keyword,'og_title'=>$keyword->keyword,'og_description'=>$keyword->keyword,'og_keywords'=>$keyword->keyword]);
        Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The ' . $keyword->keyword . 'was Updated.');
		return redirect()->back();
	}
	public function keywordDelete(Request $request)
	{
		$keyword = SearchKeyword::find($request->id);
        $keyword->delete();
        Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The ' . $keyword->keyword . 'was Deleted.');
		return redirect()->back();
	}
	public function keywordRedeactive(Request $request, $id)
	{
        $keyword = SearchKeyword::find($id);
        $keyword->update(['status'=>'0']);
        Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The ' . $keyword->keyword . 'was Updated.');
		return redirect()->back();
	}

	public function LandingPage(Request $request){
		if($request->get('search')){
			$search = \Request::get('search');
			$product_landingpages = ProductLandingPage::where('title', 'like', '%'.$search.'%')->paginate(10);
   		 }else{
	$product_landingpages = ProductLandingPage::orderBy('id','desc')->paginate(10);
		 }
	$active = Product::where('active_flag', 1);
		return view('products.landingpages',compact('product_landingpages','active'));
	}

	public function createLandingPage(Request $request){
	    $products = Product::whereHas('company',function ($q){
                             $q->where('active_flag',1);
                          })->whereNotNull('company_id')
                          ->where('active_flag',1)
                          ->get();
		return view('products.create_landingpages',compact('products'));
	}
	public function storeLandingPage(Request $request){
	   
		$product_landingpage = new ProductLandingPage;
		$product_landingpage->title = $request->title;
		$product_landingpage->description = $request->description;
		$product_landingpage->active_flag = $request->active_flag;
		$product_landingpage->stage = $request->stage;
		$product_landingpage->url = Str::slug($request->url,'-');
		$product_landingpage->products_id = implode(',',$request->product_id);
		
		$product_landingpage->save();
		// insert multiple values into single column in laravel
		
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product Landing Page was added.');
		return redirect()->route('product_landingpages')
          ->with('success','Product Landing Page has been created successfully.');
	}

	public function editLandingPage($id){
		$products = Product::whereHas('company',function ($q){
                             $q->where('active_flag',1);
                          })->whereNotNull('company_id')
                          ->where('active_flag',1)
                          ->get();
	 	$product_landingpages = ProductLandingPage::find($id);
		return view('products.edit-landingpages',compact('product_landingpages','products'));
	 }
public function updateLandingPage(Request $request, $id){
    
		$product_landingpage = ProductLandingPage::find($id);
		$product_landingpage->title = $request->title;
		$product_landingpage->description = $request->description;
		$product_landingpage->active_flag = $request->active_flag;
		$product_landingpage->stage = $request->stage;
		$product_landingpage->url = Str::slug($request->url,'-');
		$product_landingpage->products_id = implode(',',$request->product_id);
		
		$product_landingpage->save();
		
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product Landing Page was updated.');
		return redirect()->route('product_landingpages')
		  ->with('success','Product Landing Page has been updated successfully.');


	}

	public function metatagLandingPage( Request $request, $id){
		$meta = ProductLandingPage::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("meta_title");
		$meta->og_description = $request->input("meta_description");
		$meta->og_keywords = $request->input("meta_keywords");
		$meta->og_image = $request->input("og_image");
		$meta->og_video = $request->input("og_video");
		$meta->meta_region = $request->input("meta_region");
		$meta->meta_position = $request->input("meta_position");
		$meta->meta_icbm = $request->input("meta_icbm");
		$meta->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'Product Landing Page ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->back();

	}

	public function destroyLandingpage($id){

		$product_landingpage = ProductLandingPage::findOrFail($id);
		$product_landingpage->active_flag = 0;
		$product_landingpage->stage = 0;
		$product_landingpage->save();


		// $category = Category::find($products->category_id);
		//$product_landingpage->categories()->detach($category);

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product Landing Page ' . $product_landingpage->title . ' was De-Activated.');

		return redirect()->route('product_landingpages');
	}


	public function reactivateLandingpage($id){
		$product_landingpage = Product::findOrFail($id);
		$product_landingpage->active_flag = 1;
		$product_landingpage->stage = 1;
		$product_landingpage->save();

		
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Product Landing Page ' . $product_landingpage->title . ' was Re-Activated.');

		return redirect()->route('product_landingpages');
	}
}






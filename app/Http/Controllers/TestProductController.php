<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\CompanyProfile;
use App\TestProduct;
use App\Company;
use \Session;
use App\Category;
use File;

class TestProductController extends Controller
{
	protected $model;
	public function __construct(TestProduct $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search');
 			$products = TestProduct::whereHas('company' , function($query) use($search) {
 			$query->where('comp_name', 'like', '%'.$search.'%');})
	 		->orwhere('title', 'like', '%'.$search.'%')
	 		->paginate(20);
	 	$products->appends(['search' => $search]);
   		 }else{
   			$products = TestProduct::orderBy('id', 'desc')->paginate(10);
		 }
 	
		$active = TestProduct::where('active_flag', 1);
		return view('test_products.index', compact('products', 'active'));
    }

    public function create()
	{
		/*$cat = getcat(22); 
		print_r($cat);die;*/
		$companylist = Company::where('active_flag',1)->pluck('comp_name','id');
		return view('test_products.create',compact('companylist'));		
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
            'small_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',           
            'big_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',           
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
		
		$companyc->title = ucfirst($request->input("title"));
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
		$companyc->author_id = $request->user()->id;
		$companyc->display_order = $request->input("display_order");
		$companyc->type = 'admin';		
		$comp = Company::find($request->input("company_id"));
		$comp->companyproduct()->save($companyc);
		$compro = CompanyProfile::find($request->input("company_profile_id"));
		$compro->pproduct()->save($companyc);

		$category = Category::find($request->input("subcategory_id"));
		//$category = Category::find($request->input("category_id"));
		$companyc->categories()->save($category);

		return redirect()->route('testproducts.index');
	}
	public function show(TestProduct $testproduct)
	{
		$product= $testproduct;
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$product->company_id)->select('url')->first();
		return view('test_products.show', compact('product','profile'));
	}
	public function edit(TestProduct $testproduct){   
 		$product= $testproduct;
		$companylist = Company::pluck('comp_name','id');
		$profilelist = CompanyProfile::where('company_id',$product->company_id)->pluck('title','id');
		$profile = CompanyProfile::where('active_flag',1)->where('company_id',$product->company_id)->select('url')->first();
		//print_r($profile->url); die;
        return view('test_products.edit', compact('product','companylist','profilelist','profile'));
	}
	public function update(Request $request, TestProduct $testproduct, User $user){
		$product= $testproduct;
		$comp = $request->input("company_id");
		$company = Company::where('id',$comp)->select('comp_name')->first();
		$comp_url = CompanyProfile::where('company_id',$comp)->select('url')->first();
		request()->validate([
			'title' => 'required|max:255|unique:company_profiles',
			'category_id' => 'required',
            'small_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',           
            'big_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',           
            'tech_spec_pdf' => 'max:20000'            
        ]);

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

		$path = public_path('temp_companies').'/'.str_slug($company->comp_name).'/products';
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
		
		$product->title = ucfirst($request->input("title"));		
		$product->title_tag = ucfirst($request->input("title_tag"));
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
		$product->author_id = $request->user()->id;
		$product->display_order = $request->input("display_order");
				$product->save();
		// $comp = Company::find($request->input("company_id"));
		// $comp->companyproduct()->save($product);
		// $compro = CompanyProfile::find($request->input("company_profile_id"));
		// $compro->pproduct()->save($product);

		// $category = Category::find($request->input("category_id"));
		// $product->categories()->sync($category);

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The company profile \"<a href='products/$product->slug'>" . $product->title . "</a>\" was Updated.");

		return redirect()->route('testproducts.index');
	}



	public function destroy(TestProduct $testproduct,$id){
		$products = TestProduct::findOrFail($id);
		$products->active_flag = 0;
		$products->save();


		$category = Category::find($products->category_id);
		$products->categories()->detach($category);

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $products->title . ' was De-Activated.');

		return redirect()->route('testproducts.index');
	}
	public function reactivate(TestProduct $testproduct,$id){
		$products = TestProduct::findOrFail($id);
		$products->active_flag = 1;
		$products->save();

		$category = Category::find($products->category_id);
		$products->categories()->sync($category);
		
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The company profile ' . $products->title . ' was Re-Activated.');

		return redirect()->route('testproducts.index');
	}
	public function selectAjax(Request $request){

    	if($request){
    		$profiles = CompanyProfile::where('company_id',$request->company_id)->where('active_flag',1)->pluck("title","id")->all();

    		$data = view('ajax-select',compact('profiles'))->render();
    		return response()->json(['options'=>$data]);
       	}
   	}
   	public function metatag(Request $request, $id){
   		$meta = TestProduct::findOrFail($id);
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
}

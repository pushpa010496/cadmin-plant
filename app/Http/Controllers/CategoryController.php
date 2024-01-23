<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Category;
use \Session;

class CategoryController extends Controller
{
	protected $model;
	public function __construct(Category $model)
	{
		        $this->middleware('auth');

		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$categories = Category::where('name', 'like', '%'.$search.'%')->where('active_flag', 1)->paginate(20);
   		 }else{
   			$categories = Category::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		 }
		$active = Category::where('active_flag', 1);
		return view('categories.index', compact('categories', 'active'));
    }

    public function create()
	{
		$category = $this->model->get();
		//print_r($category);
		//exit();
            return view('categories.create',compact('category'));		
	}
	public function store(Request $request, User $user)
	{
		$category = new category();
		if($request->input("parent_id")){
			$parent_id = $request->input("parent_id");
		}else{
			$parent_id = 0;
		}
		request()->validate([
			'name' => 'required|max:255|unique:categories',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('category'), $imageName);
		$category->image = $imageName;	
	    }
		$category->name = ucfirst($request->input("name"));		
		$category->parent_id = $parent_id;		
		$category->slug = str_slug($request->input("name"));	
		$category->short_description = ucfirst($request->input("short_description"));		
		$category->active_flag = 1;
		$category->meta_title =ucfirst($request->input("name")).'|'. 'Global Industrial Manufacturers';
		$category->og_title=ucfirst($request->input("name")).'|'. 'Global Industrial Manufacturers';

		$category->meta_description="Industrial Manufacturing Marketplace to procure " .ucfirst($request->input("name")). " Get manufacturing company details, industrial product list, raise RFQs";
		$category->og_description="Industrial Manufacturing Marketplace to procure " .ucfirst($request->input("name")). " Get manufacturing company details, industrial product list, raise RFQs";
		$category->meta_keywords=ucfirst($request->input("name"));
		$category->og_keywords=ucfirst($request->input("name"));
		$category->author_id = $request->user()->id;
		
		$category->save();
		
		return redirect()->route('categories.index');
	}
	public function show(Category $category)
	{
		return view('categories.show', compact('category'));

	}
	public function edit(Category $category)
	{
		
	    $categories = Category::all();
	   // $technologies = Technology::where('active_flag', 1)->orderBy('tech_name')->pluck('tech_name', 'id');
		    
        return view('categories.edit', compact('category','categories'));
	}
	public function update(Request $request, Category $category, User $user)
	{
		if($request->input("parent_id")){
			$parent_id = $request->input("parent_id");
		}else{
			$parent_id = 0;
		}
		request()->validate([
			'name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('category'), $imageName);
		$category->image = $imageName;	
	    }
		$category->name = ucfirst($request->input("name"));		
		$category->parent_id = $parent_id;		
		$category->slug = str_slug($request->input("name"));	
		$category->short_description = ucfirst($request->input("short_description"));		
		$category->active_flag = 1;
		$category->author_id = $request->user()->id;
		
	
		$category->save();
	//	$category->technology()->sync($request->input("technologies"));

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The Category \"<a href='categories/$category->slug'>" . $category->name . "</a>\" was Updated.");

		return redirect()->route('categories.index');
	}

	public function destroy(Category $category)
	{
		$category->active_flag = 0;
		$category->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Category ' . $category->name . ' was De-Activated.');

		return redirect()->route('categories.index');
	}
	public function reactivate(Category $category){
		$category->active_flag = 1;
		$category->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Category ' . $category->name . ' was Re-Activated.');

		return redirect()->route('categories.index');
	}
	public function metatag(Request $request,$id){
		$meta = Category::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("og_title");
		$meta->og_description = $request->input("og_description");
		$meta->og_keywords = $request->input("og_keywords");
		$meta->og_image = $request->input("og_image");
		$meta->og_video = $request->input("og_video");
		$meta->meta_region = $request->input("meta_region");
		$meta->meta_position = $request->input("meta_position");
		$meta->meta_icbm = $request->input("meta_icbm");
		$meta->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Category ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->back();
	}
	public function getajaxcat($id)
	{
		$category = \App\Category::where('parent_id',$id)->pluck('name','id');
		return view('products.ajax', compact('category'));

	}
}

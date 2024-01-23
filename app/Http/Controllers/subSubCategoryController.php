<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Category;
use App\subCategory;
use App\subSubCategory;
use \Session;

class subSubCategoryController extends Controller
{
	protected $model;
	public function __construct(subsubCategory $model)
	{
		        $this->middleware('auth');

		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$subsubcategories = subSubCategory::where('subsubcat_name', 'like', '%'.$search.'%')->where('active_flag', 1)->paginate(20);
   		 }else{
   			$subsubcategories = subSubCategory::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		 }
		$active = subSubCategory::where('active_flag', 1);

		return view('subsubcategories.index', compact('subsubcategories', 'active'));
    }

    public function create()
	{
		$subsubcategory = $this->model->get();
		$categories = Category::where('active_flag', 1)->orderBy('id', 'desc')->get();

		return view('subsubcategories.create',compact('subsubcategory','categories'));		
	}
	public function store(Request $request, User $user)
	{
		$subsubcategory = new subsubCategory();

		request()->validate([
			'subsubcat_name' => 'required|max:255|unique:sub_sub_categories',
			'cat_id' => 'required',
			'subcat_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('subsubcategory'), $imageName);
		$subsubcategory->subsubcat_img = $imageName;	
	    }

		$subsubcategory->subsubcat_name = ucfirst($request->input("subsubcat_name"));		
		$subsubcategory->subsubcat_des = ucfirst($request->input("subsubcat_des"));		
		$subsubcategory->cat_id = $request->input("cat_id");		
		$subsubcategory->subcat_id = $request->input("subcat_id");		
		$subsubcategory->active_flag = 1;
		$subsubcategory->author_id = $request->user()->id;
		
		$subsubcategory->save();
		return redirect()->route('subsubcategories.index');
	}
	public function show(subSubCategory $subsubcategory)
	{
		return view('subsubcategories.show', compact('subsubcategory'));

	}
	public function edit(subsubCategory $subsubcategory)
	{
		
	    $subsubcategories = subSubCategory::all();
	    $category = Category::all();
	  	$categories = Category::where('active_flag', 1)->orderBy('cat_name')->pluck('cat_name', 'id');
	  	$subcategory = subCategory::where('active_flag', 1)->orderBy('subcat_name')->pluck('subcat_name', 'id');

        return view('subsubcategories.edit', compact('subsubcategory','subsubcategories','categories','category','subcategory'));
	}
	public function update(Request $request, subsubCategory $subsubcategory, User $user)
	{
		 request()->validate([
 			 'subsubcat_name' => 'required|max:255|unique:sub_sub_categories,subsubcat_name,' . $subsubcategory->id,
 			'cat_id' => 'required',
			'subcat_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);
        if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('subsubcategory'), $imageName);
        $subsubcategory->subsubcat_img = $imageName;
		}
		$subsubcategory->subsubcat_name = ucfirst($request->input("subsubcat_name"));		
		$subsubcategory->subsubcat_des = ucfirst($request->input("subsubcat_des"));		
		$subsubcategory->cat_id = $request->input("cat_id");		
		$subsubcategory->subcat_id = $request->input("subcat_id");		
		$subsubcategory->active_flag = 1;
		$subsubcategory->author_id = $request->user()->id;
		
	
		$subsubcategory->save();
	//	$subsubcategory->technology()->sync($request->input("technologies"));

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The subsubCategory \"<a href='subsubcategories/$subsubcategory->slug'>" . $subsubcategory->subsubcat_name . "</a>\" was Updated.");

		return redirect()->route('subsubcategories.index');
	}

	public function destroy(subsubCategory $subsubcategory)
	{
		$subsubcategory->active_flag = 0;
		$subsubcategory->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The subsubCategory ' . $subsubcategory->subsubcat_name . ' was De-Activated.');

		return redirect()->route('subsubcategories.index');
	}
	public function reactivate(subsubCategory $subsubcategory){
		$subsubcategory->active_flag = 1;
		$subsubcategory->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The subsubCategory ' . $subsubcategory->subsubcat_name . ' was Re-Activated.');

		return redirect()->route('subsubcategories.index');
	}
	public function ajaxcat($id){
	
	$categories = subCategory::where('cat_id',$id)->get();

	return view('subsubcategories.ajax-request', compact('categories'));
	}

	public function editajaxcat($id){
	$technology = Technology::find($id);
	$categories = $technology->category()->get();
	return view('categories.ajax-request', compact('categories'));
	}
}

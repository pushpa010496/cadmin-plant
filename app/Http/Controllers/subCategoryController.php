<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Category;
use App\subCategory;
use \Session;

class subCategoryController extends Controller
{
	protected $model;
	public function __construct(subCategory $model)
	{
		        $this->middleware('auth');

		$this->model = $model;
	}
    public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$subcategories = subCategory::where('subcat_name', 'like', '%'.$search.'%')->where('active_flag', 1)->paginate(20);
   		 }else{
   			$subcategories = subCategory::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		 }
		$active = subCategory::where('active_flag', 1);

		return view('subcategories.index', compact('subcategories', 'active'));
    }

    public function create()
	{
		$subcategory = $this->model->get();
		$categories = Category::where('active_flag', 1)->orderBy('id', 'desc')->get();

		return view('subcategories.create',compact('subcategory','categories'));		
	}
	public function store(Request $request, User $user)
	{
		$subcategory = new subCategory();

		request()->validate([
			'subcat_name' => 'required|max:255|unique:sub_categories',
			'cat_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('subcategory'), $imageName);
		$subcategory->subcat_img = $imageName;	
	    }

		$subcategory->subcat_name = ucfirst($request->input("subcat_name"));		
		$subcategory->subcat_des = ucfirst($request->input("subcat_des"));		
		$subcategory->cat_id = ucfirst($request->input("cat_id"));		
		$subcategory->active_flag = 1;
		$subcategory->author_id = $request->user()->id;
		
		$subcategory->save();
		return redirect()->route('subcategories.index');
	}
	public function show(subCategory $subcategory)
	{
		return view('subcategories.show', compact('subcategory'));

	}
	public function edit(subCategory $subcategory)
	{
		
	    $subcategories = subCategory::all();
	  	$categories = Category::where('active_flag', 1)->orderBy('cat_name')->pluck('cat_name', 'id');

        return view('subcategories.edit', compact('subcategory','subcategories','categories'));
	}
	public function update(Request $request, subCategory $subcategory, User $user)
	{
		 request()->validate([
 			 'subcat_name' => 'required|max:255|unique:sub_categories,subcat_name,' . $subcategory->id,
             'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);
        if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('subcategory'), $imageName);
        $subcategory->subcat_img = $imageName;
		}
		$subcategory->subcat_name = ucfirst($request->input("subcat_name"));		
		$subcategory->subcat_des = ucfirst($request->input("subcat_des"));		
		$subcategory->cat_id = ucfirst($request->input("cat_id"));		
		$subcategory->active_flag = 1;
		$subcategory->author_id = $request->user()->id;
		
	
		$subcategory->save();
	//	$subcategory->technology()->sync($request->input("technologies"));

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The subCategory \"<a href='subcategories/$subcategory->slug'>" . $subcategory->subcat_name . "</a>\" was Updated.");

		return redirect()->route('subcategories.index');
	}

	public function destroy(subCategory $subcategory)
	{
		$subcategory->active_flag = 0;
		$subcategory->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The subCategory ' . $subcategory->subcat_name . ' was De-Activated.');

		return redirect()->route('subcategories.index');
	}
	public function reactivate(subCategory $subcategory){
		$subcategory->active_flag = 1;
		$subcategory->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The subCategory ' . $subcategory->subcat_name . ' was Re-Activated.');

		return redirect()->route('subcategories.index');
	}
}

<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\EventCategory;
use \Session;
use \DB;
class EventCategoryController extends Controller
{
	protected $model;
	public function __construct(EventCategory $model)
	{
		        $this->middleware('auth');

		$this->model = $model;
	}
    public function index(Request $request)
    {
	$res = DB::table('event_categories as t1')->
    	join('event_categories AS t2', 't2.parent_id', '=', 't1.id')->
    	where('t1.id', 27)->pluck('t1.name','t1.id');

       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$eventcategories = EventCategory::where('name', 'like', '%'.$search.'%')->where('active_flag', 1)->paginate(20);
   		 }else{
   			$eventcategories = EventCategory::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		 }
		$active = EventCategory::where('active_flag', 1);
		return view('eventcategories.index', compact('eventcategories', 'active'));
    }

    public function create()
	{
		$ec = EventCategory::pluck('name','id');
        return view('eventcategories.create',compact('ec'));		
	}
	public function store(Request $request, User $user)
	{
		$eventcategory = new EventCategory();
		if($request->input("parent_id")){
			$parent_id = $request->input("parent_id");
		}else{
			$parent_id = 0;
		}
		request()->validate([
			'name' => 'required|max:255|unique:event_categories',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        request()->image->move(public_path('eventcategory'), $imageName);
		$eventcategory->cat_img = $imageName;	
	    }
		$eventcategory->name = ucfirst($request->input("name"));		
		$eventcategory->parent_id = $parent_id;		
		$eventcategory->slug = str_slug($request->input("name"));	
		$eventcategory->short_description = ucfirst($request->input("short_description"));		
		$eventcategory->active_flag = 1;
		$eventcategory->author_id = $request->user()->id;
		
		$eventcategory->save();
		return redirect()->route('event-categories.index');
	}
	public function show(EventCategory $category,$id)
	{
		$category = EventCategory::find($id);
		return view('eventcategories.show', compact('category'));

	}
	public function edit(EventCategory $eventcategory,$id)
	{
		$eventcategory = EventCategory::find($id);		
	   // $technologies = Technology::where('active_flag', 1)->orderBy('tech_name')->pluck('tech_name', 'id');
		    
        return view('eventcategories.edit', compact('eventcategory'));
	}
	public function update(Request $request, EventCategory $eventcategory, User $user)
	{
		$eventcategory = EventCategory::find($id);
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
			$path = public_path('eventcategory');
	         $imageName = time().'-'.$request->file('image')->getClientOriginalName();
	        if(request()->image->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$eventcategory->image)){	        		
	        		\File::delete($path.'/'.$eventcategory->image);        	        		
	        	}        	
	        }
			$eventcategory->image = $imageName;
	    }
		$eventcategory->name = ucfirst($request->input("name"));		
		$eventcategory->parent_id = $parent_id;		
		$eventcategory->slug = str_slug($request->input("name"));	
		$eventcategory->short_description = ucfirst($request->input("short_description"));		
		$eventcategory->active_flag = 1;
		$eventcategory->author_id = $request->user()->id;
		
	
		$eventcategory->save();
	//	$eventcategory->technology()->sync($request->input("technologies"));

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The Category \"<a href='eventcategories/$eventcategory->slug'>" . $eventcategory->name . "</a>\" was Updated.");

		return redirect()->route('event-categories.index');
	}

	public function destroy(EventCategory $eventcategory)
	{
		$eventcategory->active_flag = 0;
		$eventcategory->save();

		Session::flash('message_type', 'negative');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Category ' . $eventcategory->name . ' was De-Activated.');

		return redirect()->route('event-categories.index');
	}
	public function reactivate(EventCategory $eventcategory){
		$eventcategory->active_flag = 1;
		$eventcategory->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Category ' . $eventcategory->name . ' was Re-Activated.');

		return redirect()->route('event-categories.index');
	}
	public function metatag(Request $request,$id){
		$meta = EventCategory::findOrFail($id);
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
		Session::flash('message', 'Event Category ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('event-categories.index');
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Project;
use Illuminate\Http\Request;
use \Session;

class ProjectController extends Controller
{
	protected $model;

	public function __construct(Project $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$projects = Project::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$projects = Project::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Project::where('active_flag', 1);
		return view('projects.index', compact('projects', 'active'));
    }

	public function create()
	{
	    return view('projects.create');
	}
	public function store(Request $request, User $user)
	{
		$project = new project();

		request()->validate([
			'title' => 'required|max:255',
            'image' => 'required'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('project'), $imageName);
		$project->image = $imageName;	
	    }
	   	
	   	$project->date = $request->input("date");
	   	//$project->category_id = $request->input("category_id");
	   	$project->company = $request->input("company");
	   	//$project->type = $request->input("type");
	   	$project->cost = $request->input("cost");
	   	$project->source = $request->input("source");
	   	$project->country = $request->input("country");
	   	$project->title = ucfirst($request->input("title"));
		$project->img_title = ucfirst($request->input("img_title"));
		$project->img_alt = ucfirst($request->input("img_alt"));
		$project->location = ucfirst($request->input("location"));
		//$project->commencement = ucfirst($request->input("commencement"));
		$project->project_url = str_slug($request->input("project_url"), "-");
		$project->home_title = ucfirst($request->input("home_title"));
		$project->home_description = ucfirst($request->input("home_description"));
		$project->description = ucfirst($request->input("description"));
		
		$project->active_flag = $request->input("active_flag");
		$project->author_id = $request->user()->id;

		$project->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The project \"<a href='projects/$project->title'>" . $project->name . "</a>\" was Created.");

		return redirect()->route('projects.index');
	}

	public function show(Project $project)
	{
		//$project = $this->model->findOrFail($id);

		return view('projects.show', compact('project'));
	}
	public function edit(Project $project)
	{
		return view('projects.edit', compact('project'));
	}

	public function update(Request $request, project $project, User $user)
	{
		request()->validate([
			'title' => 'required|max:255',
            'image' => 'required'
        ]);
		
		if($request->file('image')){
		$path = public_path('project');
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());        
         if(request()->image->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$project->image)){	        		
	        		\File::delete($path.'/'.$project->image);        	        		
	        	}        	
	        }
		$project->image = $imageName;	
	    }
	   	
	   	$project->date = ucfirst($request->input("date"));
	   	$project->title = ucfirst($request->input("title"));
	   	//$project->category_id = $request->input("category_id");
	   	$project->country = $request->input("country");
	   	$project->company = $request->input("company");
	   	//$project->type = $request->input("type");
	   	$project->cost = $request->input("cost");
	   	$project->source = $request->input("source");
		$project->img_title = ucfirst($request->input("img_title"));
		$project->img_alt = ucfirst($request->input("img_alt"));
		$project->location = ucfirst($request->input("location"));
		//$project->commencement = ucfirst($request->input("commencement"));
		$project->project_url = str_slug($request->input("project_url"), "-");
		$project->home_title = ucfirst($request->input("home_title"));
		$project->home_description = ucfirst($request->input("home_description"));
		$project->description = ucfirst($request->input("description"));
		
		$project->active_flag = $request->input("active_flag");
		$project->author_id = $request->user()->id;


		$project->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The project \"<a href='projects/$project->title'>" . $project->name . "</a>\" was Updated.");

		return redirect()->route('projects.index');
	}
	public function destroy(Project $project)
	{
		$project->active_flag = 0;
		$project->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The project ' . $project->name . ' was De-Activated.');

		return redirect()->route('projects.index');
	}

	public function reactivate(Project $project,$id)
	{

		$project = Project::findOrFail($id);
		$project->active_flag = 1;
		$project->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The project ' . $project->name . ' was Re-Activated.');

		return redirect()->route('projects.index');
	}
	public function metatag(Request $request,$id)
	{

		$meta = Project::findOrFail($id);
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
		Session::flash('message', 'The Projects ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('projects.index');
	}
}

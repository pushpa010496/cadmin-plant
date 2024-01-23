<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Report;
use Illuminate\Http\Request;
use \Session;

class ReportController extends Controller
{
	protected $model;

	public function __construct(Report $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$reports = Report::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$reports = Report::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Report::where('active_flag', 1);
		return view('reports.index', compact('reports', 'active'));
    }

	public function create()
	{
	    return view('reports.create');
	}
	public function store(Request $request, User $user)
	{
		$reports = new Report();

		request()->validate([
			'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('reports'), $imageName);
		$reports->image = $imageName;	
	    }	   	
	   	$reports->date = ucfirst($request->input("date"));
	   	$reports->title = ucfirst($request->input("title"));
		$reports->img_title = ucfirst($request->input("img_title"));
		$reports->img_alt = ucfirst($request->input("img_alt"));
		$reports->location = ucfirst($request->input("location"));
		$reports->reports_url = str_slug($request->input("reports_url"), "-");
		$reports->home_title = ucfirst($request->input("home_title"));
		$reports->home_description = ucfirst($request->input("home_description"));
		$reports->description = ucfirst($request->input("description"));		
		$reports->active_flag = $request->input("active_flag");
		$reports->author_id = $request->user()->id;

		$reports->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The reports " . $reports->name . " was Created.");

		return redirect()->route('reports.index');
	}

	public function show(Report $report)
	{
		//$reports = $this->model->findOrFail($id);

		return view('reports.show', compact('report'));
	}
	public function edit(Report $report)
	{
		return view('reports.edit', compact('report'));
	}

	public function update(Request $request, Report $report, User $user)
	{
		request()->validate([
			'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
       if(request()->image->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$report->image)){	        		
	        		\File::delete($path.'/'.$report->image);        	        		
	        	}        	
	        }
		$report->image = $imageName;	
	    }
	   	
	   	$report->date = ucfirst($request->input("date"));
	   	$report->title = ucfirst($request->input("title"));
		$report->img_title = ucfirst($request->input("img_title"));
		$report->img_alt = ucfirst($request->input("img_alt"));
		$report->location = ucfirst($request->input("location"));
		$report->reports_url = str_slug($request->input("reports_url"), "-");
		$report->home_title = ucfirst($request->input("home_title"));
		$report->home_description = ucfirst($request->input("home_description"));
		$report->description = ucfirst($request->input("description"));		
		$report->active_flag = $request->input("active_flag");
		$report->author_id = $request->user()->id;


		$report->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The reports " . $report->name . " was Updated.");

		return redirect()->route('reports.index');
	}
	public function destroy(Report $report)
	{
		$report->active_flag = 0;
		$report->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The reports ' . $report->name . ' was De-Activated.');

		return redirect()->route('reports.index');
	}

	public function reactivate(Report $report,$id)
	{

		$report = Report::findOrFail($id);
		$report->active_flag = 1;
		$report->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The reports ' . $report->name . ' was Re-Activated.');

		return redirect()->route('reports.index');
	}
	public function metatag(Request $request,$id)
	{

		$meta = Report::findOrFail($id);
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
		Session::flash('message', 'The Reports ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->route('reports.index');
	}
}

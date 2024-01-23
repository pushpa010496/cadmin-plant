<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Cmspage;
use Illuminate\Http\Request;
use \Session;

class CmspageController extends Controller
{
	protected $model;

	public function __construct(Cmspage $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$cmspages = Cmspage::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$cmspages = Cmspage::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Cmspage::where('active_flag', 1);
		return view('cmspages.index', compact('cmspages', 'active'));
    }

	public function create()
	{
	    return view('cmspages.create');
	}
	public function store(Request $request, User $user)
	{
		$cmspage = new Cmspage();

		request()->validate([
			'title' => 'required|max:255'
        ]);
	   	
	   	$cmspage->title = ucfirst($request->input("title"));
		$cmspage->description = ucfirst($request->input("description"));
		
		$cmspage->active_flag = $request->input("active_flag");
		$cmspage->author_id = $request->user()->id;

		$cmspage->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The cmspage \"<a href='cmspages/$cmspage->title'>" . $cmspage->title . "</a>\" was Created.");

		return redirect()->route('cmspages.index');
	}

	public function show(Cmspage $cmspage)
	{
		//$cmspage = $this->model->findOrFail($id);

		return view('cmspages.show', compact('cmspage'));
	}
	public function edit(Cmspage $cmspage)
	{
		return view('cmspages.edit', compact('cmspage'));
	}

	public function update(Request $request, cmspage $cmspage, User $user)
	{
		request()->validate([
			'title' => 'required|max:255'
        ]);
	   	
	   	$cmspage->title = ucfirst($request->input("title"));
		$cmspage->description = ucfirst($request->input("description"));
		
		$cmspage->active_flag = $request->input("active_flag");
		$cmspage->author_id = $request->user()->id;
		$cmspage->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The cmspage \"<a href='cmspages/$cmspage->title'>" . $cmspage->title . "</a>\" was Updated.");

		return redirect()->route('cmspages.index');
	}
	public function destroy(Cmspage $cmspage)
	{
		$cmspage->active_flag = 0;
		$cmspage->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The cmspage ' . $cmspage->title . ' was De-Activated.');

		return redirect()->route('cmspages.index');
	}

	public function reactivate(Cmspage $cmspage,$id)
	{

		$cmspage = Cmspage::findOrFail($id);
		$cmspage->active_flag = 1;
		$cmspage->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The cmspage ' . $cmspage->title . ' was Re-Activated.');

		return redirect()->route('cmspages.index');
	}
}

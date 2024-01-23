<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use File;
use App\Newsletter;
use Illuminate\Http\Request;
use \Session;

class EventNewslatterController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var newsletter
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Newsletter $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 public function index(Request $request)
    {

       	if($request->get('search')){
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
 		$newsletters = Newsletter::where('title', 'like', '%'.$search.'%')->where('type', 'eventnewsletters')->paginate(20);
   		 }else{
   			$newsletters = Newsletter::where('type', 'eventnewsletters')->orderBy('id', 'desc')->paginate(10);
		 }
		$active = Newsletter::where('active_flag', 1);
		return view('eventnewsletters.index', compact('newsletters', 'active'));
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('eventnewsletters.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{	

		$newsletter = new newsletter();

		request()->validate([
			'title' => 'required|max:255',
			'file' => 'required|mimes:html',
			'image' => 'required|mimes:jpeg'          
        ]);
		
		if($request->file('file')){
        $fileName =  preg_replace('/\s+/','-', time().'-'.$request->file('file')->getClientOriginalName());
        request()->file->move(public_path('events-newsletters'), $fileName);
		$newsletter->file = $fileName;	
	    }

	    if($request->file('image')){
        $imageName =  preg_replace('/\s+/','-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('events-newsletters/images'), $imageName);
		$newsletter->image = $imageName;	
	    }
	   
		$newsletter->title = ucfirst($request->input("title"));
		$newsletter->type = "eventnewsletters";
		$newsletter->active_flag = $request->input("active_flag");
		$newsletter->author_id = $request->user()->id;

		$newsletter->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The newsletter \"<a href='newsletters/$newsletter->newsletter_title'>" . $newsletter->name . "</a>\" was Created.");

		return redirect()->route('eventnewsletters.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Newsletter $newsletter,$id)
	{
		$newsletter = $this->model->findOrFail($id);

		return view('eventnewsletters.show', compact('newsletter'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Newsletter $newsletter,$id)
	{

		$newsletter = $this->model->find($id);

		return view('eventnewsletters.edit', compact('newsletter'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, Newsletter $newsletter, User $user,$id)
	{

		request()->validate([
			'title' => 'required|max:255',
			'file' => 'mimes:html',
			'image' => 'mimes:jpeg'           
        ]);
		$newsletter = Newsletter::findOrFail($id);
		
		$path = public_path('events-newsletters');
		if($request->file('file')){
			$imageName =  preg_replace('/\s+/','-', time().'-'.$request->file('file')->getClientOriginalName());
			
			if(\File::exists($path.'/'.$newsletter->file)){	   	        	     	
				\File::delete($path.'/'.$newsletter->file);        	        		
			}  
			request()->file->move($path, $newsletter->file);      	
			
		// $newsletter->file = $imageName;	
		}

		if($request->file('image')){	    	
			$imageName =  preg_replace('/\s+/','-', time().'-'.$request->file('image')->getClientOriginalName());
			
			if(\File::exists($path.'/images/'.$newsletter->image)){	        		
				\File::delete($path.'/images/'.$newsletter->image);        	        		
			}        	
			request()->image->move($path.'/images/', $newsletter->image);
		// $newsletter->image = $imageName;	
		}	

	   	$newsletter->title = ucfirst($request->input("title"));
		$newsletter->type = "eventnewsletters";
		$newsletter->active_flag = $request->input("active_flag");
		$newsletter->author_id = $request->user()->id;


		$newsletter->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The newsletter \"<a href='newsletters/$newsletter->newsletter_title'>" . $newsletter->name . "</a>\" was Updated.");

		return redirect()->route('eventnewsletters.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Newsletter $newsletter,$id)
	{
		$newsletter = Newsletter::findOrFail($id);
		$newsletter->active_flag = 0;
		$newsletter->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The newsletter ' . $newsletter->name . ' was De-Activated.');

		return redirect()->route('eventnewsletters.index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(Newsletter $newsletter,$id)
	{

		$newsletter = Newsletter::findOrFail($id);
		$newsletter->active_flag = 1;
		$newsletter->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The newsletter ' . $newsletter->name . ' was Re-Activated.');

		return redirect()->route('eventnewsletters.index');
	}
}

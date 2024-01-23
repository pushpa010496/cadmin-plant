<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Partner;
use Illuminate\Http\Request;
use \Session;

class PartnerController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var partner
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(partner $model)
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
 		$partners = Partner::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$partners = Partner::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Partner::where('active_flag', 1);
		
		return view('partners.index', compact('partners', 'active'));
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('partners.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{
		$partner = new partner();

		request()->validate([
			'title' => 'required|max:255',
			'partner_url' => 'required|max:255',
            'image' => 'required',
            'home_logo' => 'required'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('partner'), $imageName);
		$partner->image = $imageName;	
	    }
	    if($request->file('home_logo')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('home_logo')->getClientOriginalName());
        request()->home_logo->move(public_path('partner'), $imageName);
		$partner->home_logo = $imageName;	
	    }

		$partner->partner_url = $request->input("partner_url");
		$partner->title = ucfirst($request->input("title"));
		$partner->img_title = ucfirst($request->input("img_title"));
		$partner->img_alt = ucfirst($request->input("img_alt"));
		$partner->type = ucfirst($request->input("type"));
		$partner->active_flag = $request->input("active_flag");
		$partner->author_id = $request->user()->id;
		$partner->url_active= $request->input("optradio1");

		$partner->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The partner \"<a href='partners/$partner->title'>" . $partner->name . "</a>\" was Created.");

		return redirect()->route('partners.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(partner $partner)
	{
		//$partner = $this->model->findOrFail($id);

		return view('partners.show', compact('partner'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(partner $partner)
	{
		//$partner = $this->model->findOrFail($id);

		return view('partners.edit', compact('partner'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, partner $partner, User $user)
	{
		// request()->validate([
		// 	'title' => 'required|max:255',
		// 	'partner_url' => 'required|max:255',
  //           'image' => 'required',
  //           'home_logo' => 'required'
  //       ]);
		
		$path = public_path('partner');
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        if(request()->image->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$partner->image)){	        		
	        		\File::delete($path.'/'.$partner->image);        	        		
	        	}        	
	        }
		$partner->image = $imageName;	
	    }
	    if($request->file('home_logo')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('home_logo')->getClientOriginalName());
         if(request()->home_logo->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$partner->home_logo)){	        		
	        		\File::delete($path.'/'.$partner->home_logo);        	        		
	        	}        	
	        }
		$partner->home_logo = $imageName;	
	    }

		$partner->partner_url = $request->input("partner_url");
		$partner->title = ucfirst($request->input("title"));
		$partner->img_title = ucfirst($request->input("img_title"));
		$partner->img_alt = ucfirst($request->input("img_alt"));
		$partner->type = ucfirst($request->input("type"));
		$partner->active_flag = $request->input("active_flag");
		$partner->author_id = $request->user()->id;
		$partner->url_active= $request->input("optradio1");

		$partner->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The partner \"<a href='partners/$partner->title'>" . $partner->name . "</a>\" was Updated.");

		return redirect()->route('partners.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(partner $partner)
	{
		$partner->active_flag = 0;
		$partner->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The partner ' . $partner->name . ' was De-Activated.');

		return redirect()->route('partners.index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(partner $partner,$id)
	{

		$partner = Partner::findOrFail($id);
		$partner->active_flag = 1;
		$partner->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The partner ' . $partner->name . ' was Re-Activated.');

		return redirect()->route('partners.index');
	}
}

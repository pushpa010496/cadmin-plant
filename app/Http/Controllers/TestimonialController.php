<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Testimonial;
use Illuminate\Http\Request;
use \Session;

class TestimonialController extends Controller
{
	protected $model;

	public function __construct(Testimonial $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$testimonials = Testimonial::where('client_name', 'like', '%'.$search.'%')->orWhere('company_name', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$testimonials = Testimonial::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Testimonial::where('active_flag', 1);
		return view('testimonials.index', compact('testimonials', 'active'));
    }

	public function create()
	{
	    return view('testimonials.create');
	}
	public function store(Request $request, User $user)
	{
		$testimonial = new testimonial();

		request()->validate([
			'client_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('testimonial'), $imageName);
		$testimonial->image = $imageName;	
	    }
	   	
	   	$testimonial->client_name = ucfirst($request->input("client_name"));
		$testimonial->img_title = ucfirst($request->input("img_title"));
		$testimonial->img_alt = ucfirst($request->input("img_alt"));
		$testimonial->company_name = ucfirst($request->input("company_name"));
		$testimonial->designation = ucfirst($request->input("designation"));
		$testimonial->description = ucfirst($request->input("description"));
		$testimonial->adv_description = ucfirst($request->input("adv_description"));
		$testimonial->active_flag = $request->input("active_flag");
		$testimonial->author_id = $request->user()->id;

		$testimonial->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The testimonial \"<a href='testimonials/$testimonial->client_name'>" . $testimonial->name . "</a>\" was Created.");

		return redirect()->route('testimonials.index');
	}

	public function show(Testimonial $testimonial)
	{
		//$testimonial = $this->model->findOrFail($id);

		return view('testimonials.show', compact('testimonial'));
	}
	public function edit(Testimonial $testimonial)
	{
		//$testimonial = $this->model->findOrFail($id);

		return view('testimonials.edit', compact('testimonial'));
	}

	public function update(Request $request, testimonial $testimonial, User $user)
	{
		request()->validate([
			'client_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		 if($request->file('image')){
			$path = public_path('testimonial');
			$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
			if(request()->image->move($path, $imageName)){
				if(\File::exists($path.'/'.$testimonial->image)){	        		
					\File::delete($path.'/'.$testimonial->image);        	        		
				}        	
			}
			$testimonial->image = $imageName;	
		}
	   	
	   	$testimonial->client_name = ucfirst($request->input("client_name"));
		$testimonial->img_title = ucfirst($request->input("img_title"));
		$testimonial->img_alt = ucfirst($request->input("img_alt"));
		$testimonial->company_name = ucfirst($request->input("company_name"));
		$testimonial->designation = ucfirst($request->input("designation"));
		$testimonial->description = ucfirst($request->input("description"));
		$testimonial->adv_description = ucfirst($request->input("adv_description"));
		$testimonial->active_flag = $request->input("active_flag");
		$testimonial->author_id = $request->user()->id;

		$testimonial->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The testimonial \"<a href='testimonials/$testimonial->title'>" . $testimonial->name . "</a>\" was Updated.");

		return redirect()->route('testimonials.index');
	}
	public function destroy(Testimonial $testimonial)
	{
		$testimonial->active_flag = 0;
		$testimonial->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The testimonial ' . $testimonial->name . ' was De-Activated.');

		return redirect()->route('testimonials.index');
	}

	public function reactivate(Testimonial $testimonial,$id)
	{

		$testimonial = Testimonial::findOrFail($id);
		$testimonial->active_flag = 1;
		$testimonial->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The testimonial ' . $testimonial->name . ' was Re-Activated.');

		return redirect()->route('testimonials.index');
	}
}

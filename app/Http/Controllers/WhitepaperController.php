<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Whitepaper;
use Illuminate\Http\Request;
use \Session;

class WhitepaperController extends Controller
{
	protected $model;

	public function __construct(Whitepaper $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
    	
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$whitepapers = Whitepaper::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$whitepapers = Whitepaper::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Whitepaper::where('active_flag', 1);
		return view('whitepapers.index', compact('whitepapers', 'active'));
    }

	public function create()
	{
	    return view('whitepapers.create');
	}
	public function store(Request $request, User $user)
	{
		$whitepapers = new Whitepaper();

		request()->validate([
			'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'whitepapers_url' => 'required|unique:whitepapers,whitepapers_url'
        ]);
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('whitepapers'), $imageName);
		$whitepapers->image = $imageName;	
	    }	
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/', '-', time().'-'.$request->file('pdf')->getClientOriginalName());
        request()->pdf->move(public_path('whitepapers'), $pdfName);
		$whitepapers->pdf = $pdfName;	
	    }	   	
	   	$whitepapers->date = ucfirst($request->input("date"));
	   	$whitepapers->title = ucfirst($request->input("title"));
		$whitepapers->img_title = ucfirst($request->input("img_title"));
		$whitepapers->img_alt = ucfirst($request->input("img_alt"));
		$whitepapers->whitepapers_url = str_slug($request->input("whitepapers_url"), "-");
		$whitepapers->home_title = ucfirst($request->input("home_title"));
		$whitepapers->home_description = ucfirst($request->input("home_description"));
		$whitepapers->description = ucfirst($request->input("description"));		
		$whitepapers->active_flag = $request->input("active_flag");
		$whitepapers->author_id = $request->user()->id;

		$whitepapers->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The whitepapers " . $whitepapers->name . " was Created.");

		return redirect()->route('whitepapers.index');
	}

	public function show(Whitepaper $whitepaper)
	{
		//$whitepapers = $this->model->findOrFail($id);

		return view('whitepapers.show', compact('whitepaper'));
	}
	public function edit(Whitepaper $whitepaper)
	{
		return view('whitepapers.edit', compact('whitepaper'));
	}

	public function update(Request $request, Whitepaper $whitepaper, User $user)
	{
		request()->validate([
			'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
		
		$path = public_path('whitepapers');
		if($request->file('image')){
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        if(request()->image->move($path, $imageName)){
	        	if(\File::exists($path.'/'.$whitepaper->image)){	        		
	        		\File::delete($path.'/'.$whitepaper->image);        	        		
	        	}        	
	        }
		$whitepaper->image = $imageName;	
	    }	
	    if($request->file('pdf')){
        $pdfName = preg_replace('/\s+/', '-', time().'-'.$request->file('pdf')->getClientOriginalName());
         if(request()->image->move($path, $pdfName)){
	        	if(\File::exists($path.'/'.$whitepaper->pdf)){	        		
	        		\File::delete($path.'/'.$whitepaper->pdf);        	        		
	        	}        	
	        }
		$whitepaper->pdf = $pdfName;	
	    }	     	
	   	$whitepaper->date = ucfirst($request->input("date"));
	   	$whitepaper->title = ucfirst($request->input("title"));
		$whitepaper->img_title = ucfirst($request->input("img_title"));
		$whitepaper->img_alt = ucfirst($request->input("img_alt"));
		$whitepaper->whitepapers_url = str_slug($request->input("whitepapers_url"), "-");
		$whitepaper->home_title = ucfirst($request->input("home_title"));
		$whitepaper->home_description = ucfirst($request->input("home_description"));
		$whitepaper->description = ucfirst($request->input("description"));		
		$whitepaper->active_flag = $request->input("active_flag");
		$whitepaper->author_id = $request->user()->id;


		$whitepaper->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The whitepapers " . $whitepaper->name . " was Updated.");

		return redirect()->route('whitepapers.index');
	}
	public function destroy(Whitepaper $whitepaper)
	{
		$whitepaper->active_flag = 0;
		$whitepaper->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The whitepapers ' . $whitepaper->name . ' was De-Activated.');

		return redirect()->route('whitepapers.index');
	}

	public function reactivate(Whitepaper $whitepaper,$id)
	{

		$whitepaper = Whitepaper::findOrFail($id);
		$whitepaper->active_flag = 1;
		$whitepaper->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The whitepapers ' . $whitepaper->name . ' was Re-Activated.');

		return redirect()->route('whitepapers.index');
	}
	public function metatag(Request $request,$id)
	{
		$meta = Whitepaper::findOrFail($id);
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
		Session::flash('message', 'The Whitepaper ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->route('whitepapers.index');
	}
}

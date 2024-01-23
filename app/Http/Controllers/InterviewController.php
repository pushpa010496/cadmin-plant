<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Interview;
use Illuminate\Http\Request;
use \Session;

class InterviewController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var interview
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Interview $model)	{
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
 		$interviews = Interview::where('name', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$interviews = Interview::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Interview::where('active_flag', 1);
		return view('interviews.index', compact('interviews', 'active'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('interviews.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{

		 $check = $request->input("position_check");


		// print_r($check); die;
		$interview = new interview();

		request()->validate([
			'name' => 'required|max:255',
			'interviews_url' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'home_position' => 'numeric',
            'small_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);



        $home_pos = Interview::select('home_position')->get();
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('interview'), $imageName);
		$interview->image = $imageName;	
	    }
	    if($request->file('small_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('small_image')->getClientOriginalName());
        request()->small_image->move(public_path('interview'), $imageName);
		$interview->small_image = $imageName;	
	    }

		$interview->interviews_url = str_slug($request->input("interviews_url"), "-");
		$interview->name = ucfirst($request->input("name"));
		$interview->img_destination_url = $request->input("img_destination_url");
		$interview->img_alt = $request->input("img_alt");
		//$interview->img_title = $request->input("img_title");
		$interview->title = $request->input("title");
		$interview->company = $request->input("company");
		$interview->designation = $request->input("designation");		
		$interview->description = ucfirst($request->input("description"));
		$interview->add_questions = ucfirst($request->input("add_questions"));
		$interview->active_flag = $request->input("active_flag");
		$interview->author_id = $request->user()->id;
		$interview->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The interview \"<a href='interviews/$interview->name'>" . $interview->name . "</a>\" was Created.");

		return redirect()->route('interviews.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Interview $interview)
	{
		//$interview = $this->model->findOrFail($id);

		return view('interviews.show', compact('interview'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Interview $interview)
	{
		//$interview = $this->model->findOrFail($id);

		return view('interviews.edit', compact('interview'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, interview $interview, User $user)
	{
		request()->validate([
			'name' => 'required|max:255',
			'interviews_url' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'small_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'
        ]);
        $home_pos = Interview::select('home_position')->get();
		
		$path = public_path('interview');
		
		if($request->file('image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());
         if(request()->image->move($path, $imageName)){
        	if(\File::exists($path.'/'.$interview->image)){	        		
        		\File::delete($path.'/'.$interview->image);        	        		
        	}        	
        }
		$interview->image = $imageName;	
	    }
	    if($request->file('small_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('small_image')->getClientOriginalName());
          if(request()->small_image->move($path, $imageName)){
        	if(\File::exists($path.'/'.$interview->small_image)){	        		
        		\File::delete($path.'/'.$interview->small_image);        	        		
        	}        	
        }
		$interview->small_image = $imageName;	
	    }

		$interview->interviews_url = str_slug($request->input("interviews_url"), "-");
		$interview->name = ucfirst($request->input("name"));
		$interview->img_destination_url = $request->input("img_destination_url");
		$interview->img_alt = $request->input("img_alt");
		//$interview->img_title = $request->input("img_title");
		$interview->title = $request->input("title");
		$interview->company = $request->input("company");
		$interview->designation = $request->input("designation");		
		$interview->description = ucfirst($request->input("description"));
		$interview->add_questions = ucfirst($request->input("add_questions"));
		$interview->active_flag = $request->input("active_flag");
		$interview->author_id = $request->user()->id;
		$interview->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The interview \"<a href='interviews/$interview->name'>" . $interview->name . "</a>\" was Updated.");

		return redirect()->route('interviews.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Interview $interview)
	{
		$interview->active_flag = 0;
		$interview->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The interview ' . $interview->name . ' was De-Activated.');

		return redirect()->route('interviews.index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(Interview $interview,$id)
	{

		$interview = Interview::findOrFail($id);
		$interview->active_flag = 1;
		$interview->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The interview ' . $interview->name . ' was Re-Activated.');

		return redirect()->route('interviews.index');
	}
	public function metatag(Request $request, $id){
		$meta = Interview::findOrFail($id);
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
		Session::flash('message', 'The interview ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->route('interviews.index');
	}
	public function InterviewPositions(Request $request){

		$position_interviews = Interview::where('active_flag',1)->pluck('name','id');
		

		$position_interviews1 = Interview::where('home_position',1)->select('name','id')->first();

		$position_interviews2 = Interview::where('home_position',2)->select('name','id')->first();
		$position_interviews3 = Interview::where('home_position',3)->select('name','id')->first();
		$position_interviews4 = Interview::where('home_position',4)->select('name','id')->first();

		//print_r($position_interviews2); die;
		

		return view('interviews.interview_position',compact('position_interviews','position_interviews1','position_interviews2','position_interviews3','position_interviews4'));
	}
	public function InterviewPositionsUpdate(Request $request){

		if($request->input('position1')){
			$position_update = Interview::where('home_position',1)
          ->update(['home_position' => '']);;

			$positon1 = Interview::findOrFail($request->input('position1'));
			
			$positon1->home_position = '1';
			$positon1->save();
		}
		else{
			$positon1->home_position = '';
			$positon1->save();
		}

			
		if($request->input('position2')){
			$position_update = Interview::where('home_position',2)
          ->update(['home_position' => '']);;
			$positon2 = Interview::findOrFail($request->input('position2'));	

			$positon2->home_position = '2';
			$positon2->save();
		}
		else{
			$positon2->home_position = '';
			$positon2->save();
		}

		if($request->input('position3')){
			$position_update = Interview::where('home_position',3)
          ->update(['home_position' => '']);;
			$positon3 = Interview::findOrFail($request->input('position3'));	

			$positon3->home_position = '3';
			$positon3->save();
		}

		else{
			$positon3->home_position = '';
			$positon3->save();
		}
		if($request->input('position4')){
			$position_update = Interview::where('home_position',4)
          ->update(['home_position' => '']);;
			$positon4 = Interview::findOrFail($request->input('position4'));	

			$positon4->home_position = '4';
			$positon4->save();
		}
		else{
			$positon4->home_position = '';
			$positon4->save();
		}
		//print_r($position_interviews); die;
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The interviews Positions has added.');

		return redirect()->back();
	}
}

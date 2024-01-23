<?php



namespace App\Http\Controllers;



use App\Http\Requests;

use App\Http\Controllers\Controller;



use App\User;

use Auth;

use Illuminate\Support\Facades\Hash;

use App\Event;

use App\EventOrg;

use App\EventCategory;

use Illuminate\Http\Request;

use \Session;
use Illuminate\Support\Str;




class EventController extends Controller

{

	protected $model;



	public function __construct(Event $model)

	{

		$this->model = $model;

		$this->middleware('auth');

	}



	 public function index(Request $request)

    {

       	if($request->get('search')){

		$search = \Request::get('search'); 

 		$events = Event::where('name', 'like', '%'.$search.'%')->paginate(20);

   		 }else{

   			$events = Event::orderBy('id', 'desc')->paginate(10);

		 }

		$active = Event::where('active_flag', 1);

		return view('events.index', compact('events', 'active'));

    }



	public function create()

	{

		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');



	    return view('events.create',compact('eventlist'));

	}

	public function store(Request $request, User $user)

	{

		$role = 6;

		$event = new event();



		request()->validate([

			'name' => 'required|max:255',

            'image' => 'required',

            'big_image' =>'required'

        ]);

		

		if($request->file('image')){

        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());

        request()->image->move(public_path('event'), $imageName);

		$event->image = $imageName;	

	    }



	    if($request->file('big_image')){

	    	$big_image = preg_replace('/\s+/','-',time().'-'.$request->file('big_image')->getClientOriginalName());

			request()->big_image->move(public_path('event'),$big_image);

			$event->big_image = $big_image;

	    }

	   	$event->cat_id = $request->input("parent_id");	   	

	   	//$event->cat_id = 0;	   	

	   	$event->event_org_id = $request->input("event_org_id");	   	

	  	$event->start_date = date("Y-m-d",strtotime($request->input("start_date")));

	   	$event->end_date = date("Y-m-d",strtotime($request->input("end_date")));	

	   	$event->name = $request->input("name");

	   	$event->venue = ucfirst($request->input("venue"));

	   	$event->address = ucfirst($request->input("address"));

	   	$event->organiser = ucfirst($request->input("organiser"));

	   	$event->country = ucfirst($request->input("country"));

	   	$event->org_name = ucfirst($request->input("org_name"));

	   	$event->phone = ucfirst($request->input("phone"));

	   	$event->email = ucfirst($request->input("email"));

	   	$event->web_link = ucfirst($request->input("web_link"));

		$event->description = ucfirst($request->input("description"));



		$event->img_title = ucfirst($request->input("img_title"));

		$event->img_alt = ucfirst($request->input("img_alt"));

		$event->link_status = ucfirst($request->input("link_status"));

		$event->event_type = ucfirst($request->input("event_type"));

		$event->event_url =Str::slug($request->input("event_url"), "-");

		$event->home_title = ucfirst($request->input("home_title"));

		

		$event->active_flag = $request->input("active_flag");

		$event->author_id = $request->user()->id;



		$event->save();



		//user registration		

		if(count(User::where('email',$request->input("email"))->get()) == 0){

				$user = new User();

				$user->name = $request->input("name");

				$user->email = $request->input("email");

				$user->password = bcrypt($request->input("password"));

				$user->active_flag = 1;

				$user->save();

				$user->attachRole($role);

		}



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The event \"<a href='events/$event->name'>" . $event->name . "</a>\" was Created.");



		return redirect()->route('events.index');

	}



	public function show(Event $event)

	{

		//$event = $this->model->findOrFail($id);

		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');



		return view('events.show', compact('event','eventlist'));

	}

	public function edit(Event $event)

	{

		//return $event;



		$eventlist = EventOrg::where('active_flag',1)->pluck('name','id');

		//$eventcategory = EventCategory::where('active_flag',1)->pluck('name','id');



		return view('events.edit', compact('event','eventlist'));

	}



	public function update(Request $request, event $event, User $user)

	{



		// request()->validate([

		// 	'name' => 'required|max:255',

  //           'image' => 'required',

  //           'big_image' =>'required'

  //       ]);

		

		$path = public_path('event');

		if($request->file('image')){	

			$imageName = preg_replace('/\s+/','-',time().'-'.$request->file('image')->getClientOriginalName());        

			if(request()->image->move($path, $imageName)){

				if(\File::exists($path.'/'.$event->image)){	        		

					\File::delete($path.'/'.$event->image);        	        		

				}        	

			}

			$event->image = $imageName;	

	    }

	    if($request->file('big_image')){

			$big_imageName = preg_replace('/\s+/','-',time().'-'.$request->file('big_image')->getClientOriginalName());        

			if(request()->big_image->move($path, $big_imageName)){

				if(\File::exists($path.'/'.$event->big_image)){	        		

					\File::delete($path.'/'.$event->big_image);        	        		

				}        	

			}

			$event->big_image = $big_imageName;	

			

	    }

	   	

	   	$event->cat_id = $request->input("parent_id");	

	   	$event->event_org_id = $request->input("event_org_id");	   	

	   	$event->start_date = date("Y-m-d",strtotime($request->input("start_date")));

	   	$event->end_date = date("Y-m-d",strtotime($request->input("end_date")));	

	   	$event->name = $request->input("name");

	   	$event->venue = ucfirst($request->input("venue"));

	   	$event->address = ucfirst($request->input("address"));

	   	$event->organiser = ucfirst($request->input("organiser"));

	   	$event->country = ucfirst($request->input("country"));

	   	$event->org_name = ucfirst($request->input("org_name"));

	   	$event->phone = ucfirst($request->input("phone"));

	   	$event->email = ucfirst($request->input("email"));

	   	$event->web_link = ucfirst($request->input("web_link"));

		$event->description = ucfirst($request->input("description"));



		$event->img_title = ucfirst($request->input("img_title"));

		$event->img_alt = ucfirst($request->input("img_alt"));

		$event->link_status = ucfirst($request->input("link_status"));

		$event->event_type = ucfirst($request->input("event_type"));

		$event->event_url = $request->input("event_url");

		$event->home_title = ucfirst($request->input("home_title"));

		

		$event->active_flag = $request->input("active_flag");

		$event->author_id = $request->user()->id;



		$event->save();



		//user update



		$user = User::where('email',$request->input("email"))->first();

		if($user){

			$user->name = $request->input("name");

			$user->email = $request->input("email");		

			$user->save();

	

		}

		

		Session::flash('message_type', 'warning');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The event \"<a href='events/$event->title'>" . $event->name . "</a>\" was Updated.");



		return redirect()->route('events.index');

	}

	public function destroy(Event $event)

	{

		$event->active_flag = 0;

		$event->save();



		Session::flash('message_type', 'danger');

		Session::flash('message_icon', 'hide');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The event ' . $event->name . ' was De-Activated.');



		return redirect()->route('events.index');

	}



	public function reactivate(Event $event,$id)

	{



		$event = Event::findOrFail($id);

		$event->active_flag = 1;

		$event->save();



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The event ' . $event->name . ' was Re-Activated.');



		return redirect()->route('events.index');

	}

	public function metatag(Request $request,$id){

		$meta = Event::findOrFail($id);

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

		Session::flash('message', 'Events ' . $meta->meta_title . ' Metatags was added.');





		return redirect()->route('events.index');

	}

}


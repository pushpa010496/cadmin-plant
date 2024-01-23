<?php



namespace App\Http\Controllers;



use App\Http\Requests;

use App\Http\Controllers\Controller;



use App\User;

use Auth;

use App\Xmlpharse;

use App\Pressrelease;

use Illuminate\Http\Request;

use \Session;



class PressreleaseController extends Controller

{

	protected $model;



	public function __construct(Pressrelease $model)

	{

		$this->model = $model;

		$this->middleware('auth');

	}



	public function index(Request $request)

    {

       	if($request->get('search')){

    		$search = \Request::get('search'); 

     		$pressreleases = \DB::table('news_xml')->where('news_head', 'like', '%'.$search.'%')->paginate(10);

   		 }

   		 else

   		 {

   			$pressreleases = \DB::table('news_xml')->orderBy('id', 'desc')->paginate(10);

		 }

		$active =\DB::table('news_xml')->where('active_flag', 1);

		return view('pressreleases.index', compact('pressreleases','active'));

    }



	public function create()

	{

	    return view('pressreleases.create');

	}

	public function store(Request $request, User $user)

	{

	/*	$pressreleases = new Pressrelease();



		request()->validate([

			'title' => 'required|max:255',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);

		

		if($request->file('image')){

        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());

        request()->image->move(public_path('pressreleases'), $imageName);

		$pressreleases->image = $imageName;	

	    }	   	

	   	$pressreleases->date = ucfirst($request->input("date"));

	   	$pressreleases->title = ucfirst($request->input("title"));

	   	$pressreleases->meta_title = $request->input("title");

		$pressreleases->meta_description = $request->input("home_description");

		$pressreleases->img_title = ucfirst($request->input("img_title"));

		$pressreleases->img_alt = ucfirst($request->input("img_alt"));

		$pressreleases->location = ucfirst($request->input("location"));

		$pressreleases->pressreleases_url = str_slug($request->input("pressreleases_url"), "-");

		$pressreleases->home_title = ucfirst($request->input("home_title"));

		$pressreleases->home_description = ucfirst($request->input("home_description"));

		$pressreleases->description = ucfirst($request->input("description"));		

		$pressreleases->active_flag = $request->input("active_flag");

		$pressreleases->author_id = $request->user()->id;



		$pressreleases->save();*/



		$xml_press=new Xmlpharse();

		request()->validate([

			'title' => 'required|max:255',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);

		$xml_press->story_date = ucfirst($request->input("date"));

	   	$xml_press->news_head = ucfirst($request->input("title"));

		//$xml_press->img_title = ucfirst($request->input("img_title"));

		//$xml_press->img_alt = ucfirst($request->input("img_alt"));

		$xml_press->location = ucfirst($request->input("location"));

		$xml_press->news_url = str_slug($request->input("pressreleases_url"), "-");

		//$xml_press->home_title = ucfirst($request->input("home_title"));

         $info=preg_replace('/[^a-zA-Z]/', '', $request->input('description'));



		$xml_press->Data = ucfirst($request->input('description'));

		$xml_press->home_description  = ucfirst($request->input("home_description"));

		//$xml_press->description = ucfirst($request->input("description"));		

		$xml_press->active_flag = $request->input("active_flag");

		$xml_press->type = "Ochre";

		$xml_press->author_id = $request->user()->id;

 		$xml_press->meta_title = $request->input("title");

		$xml_press->meta_description = $request->input("home_description");

		$xml_press->save();



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The pressreleases " . $request->input("title") . " was Created.");



		return redirect()->route('pressreleases.index');

	}



	public function show(Xmlpharse $pressrelease)

	{

		//$pressreleases = $this->model->findOrFail($id);



		return view('pressreleases.show', compact('pressrelease'));

	}

	public function edit(Xmlpharse $pressrelease)

	{

		

		return view('pressreleases.edit', compact('pressrelease'));

	}



	public function update(Request $request,Xmlpharse $pressrelease)

	{

		$xml_press = $pressrelease;

		request()->validate([

			'title' => 'required|max:255',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);

		

		if($request->file('image')){

			$path = public_path('pressreleases');

	        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());

	        if(request()->image->move($path, $imageName)){

	        	if(\File::exists($path.'/'.$pressrelease->image)){	        		

	        		\File::delete($path.'/'.$pressrelease->image);        	        		

	        	}        	

	        }

			$pressrelease->image = $imageName;	

			

	    }

	   /*	//$pressrelease=Pressrelease::find($pressrelease->id);

	   	$pressrelease->date = ucfirst($request->input("date"));

	   	$pressrelease->title = ucfirst($request->input("title"));

		$pressrelease->img_title = ucfirst($request->input("img_title"));

		$pressrelease->img_alt = ucfirst($request->input("img_alt"));

		$pressrelease->location = ucfirst($request->input("location"));

		$pressrelease->pressreleases_url = str_slug($request->input("pressreleases_url"), "-");

		$pressrelease->home_title = ucfirst($request->input("home_title"));

		$pressrelease->home_description = ucfirst($request->input("home_description"));

		$pressrelease->description = ucfirst($request->input("description"));		

		$pressrelease->active_flag = $request->input("active_flag");

		$pressrelease->author_id = $request->user()->id;





		$pressrelease->save();

*/

		

		

		$xml_press->story_date = ucfirst($request->input("date"));

	   	$xml_press->news_head = ucfirst($request->input("title"));

		//$xml_press->img_title = ucfirst($request->input("img_title"));

		//$xml_press->img_alt = ucfirst($request->input("img_alt"));

		$xml_press->location = ucfirst($request->input("location"));

		$xml_press->news_url = str_slug($request->input("pressreleases_url"), "-");

		//$xml_press->home_title = ucfirst($request->input("home_title"));



		  $info=preg_replace('/[^a-zA-Z]/', '', $request->input('description'));



		$xml_press->Data = ucfirst($request->input('description'));





		//$xml_press->Data = ucfirst($request->input("description"));

		//$xml_press->description = ucfirst($request->input("description"));		

		$xml_press->active_flag = $request->input("active_flag");

		$xml_press->type = "Ochre";

		$xml_press->author_id = $request->user()->id;

 		$xml_press->meta_title = $request->input("title");

		$xml_press->meta_description = $request->input("home_description");

		$xml_press->home_description  = ucfirst($request->input("home_description"));

		$xml_press->save();



		Session::flash('message_type', 'warning');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The pressreleases " . $request->input("title") . " was Updated.");



		return redirect()->route('pressreleases.index');

	}

	public function destroy(Xmlpharse $pressrelease)

	{

		$pressrelease->active_flag = 0;

		$pressrelease->save();



		Session::flash('message_type', 'danger');

		Session::flash('message_icon', 'hide');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The pressreleases ' . $pressrelease->name . ' was De-Activated.');



		return redirect()->route('pressreleases.index');

	}



	public function reactivate(Xmlpharse $pressrelease,$id)

	{



		$pressrelease = Xmlpharse::findOrFail($id);

		$pressrelease->active_flag = 1;

		$pressrelease->save();



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The pressreleases ' . $pressrelease->name . ' was Re-Activated.');



		return redirect()->route('pressreleases.index');

	}

	public function metatag(Request $request,$id)

	{



		$meta = Xmlpharse::findOrFail($id);

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

		Session::flash('message', 'The Pressreleases ' . $meta->meta_title . ' Metatags was added.');



		return redirect()->back();

	}

}


<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\News;
use Illuminate\Http\Request;
use \Session;
class NewsController extends Controller

{

	protected $model;



	public function __construct(News $model)

	{

		$this->model = $model;

		$this->middleware('auth');

	}


    
    public function index(Request $request)
        {
           	if($request->get('search'))
           	{
        		$search = \Request::get('search'); 
         		$news = News::select('id','date','title','news_url')->where('title', 'like', '%'.$search.'%')->paginate(10);
       		 }
       		 else
       		 {
       			$news = News::select('id','date','title','news_url')->orderBy('id', 'desc')->paginate(10);
    		 }
    		$active = News::select('id','date','title','news_url')->where('active_flag', 1);
    		return view('news.index', compact('news','active'));
        }



	public function create()

	{

	    return view('news.create');

	}

	public function store(Request $request, User $user)

	{

		$news = new News();



		request()->validate([

			'title' => 'required|max:255',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);

		

		if($request->file('image')){

        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());

        request()->image->move(public_path('news'), $imageName);

		$news->image = $imageName;	

	    }	   	

	   	$news->date = ucfirst($request->input("date"));

	   	$news->title = ucfirst($request->input("title"));

	   	$news->meta_title = $request->input("title");

		$news->meta_description = $request->input("home_description");

		$news->img_title = ucfirst($request->input("img_title"));

		$news->img_alt = ucfirst($request->input("img_alt"));

		$news->location = ucfirst($request->input("location"));

		$news->news_url = str_slug($request->input("news_url"), "-");

		$news->home_title = ucfirst($request->input("home_title"));

		$news->home_description = ucfirst($request->input("home_description"));

		$news->description = ucfirst($request->input("description"));		

		$news->active_flag = $request->input("active_flag");

		$news->author_id = $request->user()->id;



		$news->save();



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The news " . $news->name . " was Created.");



		return redirect()->route('news.index');

	}



	public function show(News $news)

	{

		//$news = $this->model->findOrFail($id);



		return view('news.show', compact('news'));

	}

	public function edit(News $news)

	{

		return view('news.edit', compact('news'));

	}



	public function update(Request $request, News $news, User $user)

	{

		request()->validate([

			'title' => 'required|max:255',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000'

        ]);

		

		if($request->file('image')){

			$path = public_path('news');			

			$imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());

			if(request()->image->move($path, $imageName)){

				if(\File::exists($path.'/'.$eventorg->image)){	        		

					\File::delete($path.'/'.$eventorg->image);        	        		

				}        	

			}

			$news->image = $imageName;	

	    }

	   	

	   	$news->date = ucfirst($request->input("date"));

	   	$news->title = ucfirst($request->input("title"));

		$news->img_title = ucfirst($request->input("img_title"));

		$news->img_alt = ucfirst($request->input("img_alt"));

		$news->location = ucfirst($request->input("location"));

		$news->news_url = str_slug($request->input("news_url"), "-");

		$news->home_title = ucfirst($request->input("home_title"));

		$news->home_description = ucfirst($request->input("home_description"));

		$news->description = ucfirst($request->input("description"));		

		$news->active_flag = $request->input("active_flag");

		$news->author_id = $request->user()->id;





		$news->save();



		Session::flash('message_type', 'warning');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', "The news " . $news->name . " was Updated.");



		return redirect()->route('news.index');

	}

	public function destroy(News $news)

	{

		$news->active_flag = 0;

		$news->save();



		Session::flash('message_type', 'danger');

		Session::flash('message_icon', 'hide');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The news ' . $news->name . ' was De-Activated.');



		return redirect()->route('news.index');

	}



	public function reactivate(News $news,$id)

	{



		$news = News::findOrFail($id);

		$news->active_flag = 1;

		$news->save();



		Session::flash('message_type', 'success');

		Session::flash('message_icon', 'checkmark');

		Session::flash('message_header', 'Success');

		Session::flash('message', 'The news ' . $news->name . ' was Re-Activated.');



		return redirect()->route('news.index');

	}

	public function metatag(Request $request,$id)

	{

		$meta = News::findOrFail($id);

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

		Session::flash('message', 'The News ' . $meta->meta_title . ' Metatags was added.');



		return redirect()->back();

	}

}


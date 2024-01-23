<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Article;
use Illuminate\Http\Request;
use \Session;

class ArticlesController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var article
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Article $model)
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
 		$articles = Article::where('article_title', 'like', '%'.$search.'%')->where('active_flag', 1)->paginate(20);
   		 }else{
   			$articles = Article::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		 }
		$active = Article::where('active_flag', 1);
		return view('articles.index', compact('articles', 'active'));
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('articles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{
		$article = new article();

		request()->validate([
			// 'auther_name' => 'required|max:255',
			// 'auther_designation' => 'required|max:255',
   //          'auther_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
   //          'auther_description' => 'required|max:255',

			'article_title' => 'required|max:255',
			'article_url' => 'required|max:255'
        ]);
		
		if($request->file('article_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('article_image')->getClientOriginalName());
        request()->article_image->move(public_path('articles'), $imageName);
		$article->article_image = $imageName;	
	    }
	    if($request->file('small_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('small_image')->getClientOriginalName());
        request()->small_image->move(public_path('articles'), $imageName);
		$article->small_image = $imageName;	
	    }

	    if($request->file('auther_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('auther_image')->getClientOriginalName());
        request()->auther_image->move(public_path('articles'), $imageName);
		$article->auther_image = $imageName;	
	    }

	    $article->auther_name = ucfirst($request->input("auther_name"));
		$article->auther_designation = ucfirst($request->input("auther_designation"));
		$article->auther_description = ucfirst($request->input("auther_description"));

		$article->article_url = str_slug($request->input("article_url"), "-");
		$article->home_title = ucfirst($request->input("home_title"));
		$article->short_description = ucfirst($request->input("short_description"));
		$article->article_title = ucfirst($request->input("article_title"));
		$article->article_description = ucfirst($request->input("article_description"));
		$article->active_flag = $request->input("active_flag");
		$article->author_id = $request->user()->id;

		$article->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The article \"<a href='articles/$article->article_title'>" . $article->name . "</a>\" was Created.");

		return redirect()->route('articles.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Article $article)
	{
		//$article = $this->model->findOrFail($id);

		return view('articles.show', compact('article'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Article $article)
	{
		//$article = $this->model->findOrFail($id);

		return view('articles.edit', compact('article'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, article $article, User $user)
	{
		request()->validate([
			// 'auther_name' => 'required|max:255',
			// 'auther_designation' => 'required|max:255',
   //          'auther_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
   //          'auther_description' => 'required|max:255',

			'article_title' => 'required|max:255',
			'article_url' => 'required|max:255'
           
        ]);
		
		$path = public_path('articles');
		
		if($request->file('article_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('article_image')->getClientOriginalName());
        if(request()->article_image->move($path, $imageName)){
        	if(\File::exists($path.'/'.$article->article_image)){	        		
        		\File::delete($path.'/'.$article->article_image);        	        		
        	}        	
        }
		$article->article_image = $imageName;	
	    }

	    if($request->file('small_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('small_image')->getClientOriginalName());
        if(request()->small_image->move($path, $imageName)){
        	if(\File::exists($path.'/'.$article->small_image)){	        		
        		\File::delete($path.'/'.$article->small_image);        	        		
        	}        	
        }
		$article->small_image = $imageName;	
	    }
	    
	    if($request->file('auther_image')){
        $imageName = preg_replace('/\s+/','-',time().'-'.$request->file('auther_image')->getClientOriginalName());
         if(request()->auther_image->move($path, $imageName)){
        	if(\File::exists($path.'/'.$article->auther_image)){	        		
        		\File::delete($path.'/'.$article->auther_image);        	        		
        	}        	
        }
		$article->auther_image = $imageName;	
	    }
	    
		$article->auther_name = ucfirst($request->input("auther_name"));
		$article->auther_designation = ucfirst($request->input("auther_designation"));
		$article->auther_description = ucfirst($request->input("auther_description"));

		$article->article_url = str_slug($request->input("article_url"), "-");
		$article->home_title = ucfirst($request->input("home_title"));
		$article->short_description = ucfirst($request->input("short_description"));
		$article->article_title = ucfirst($request->input("article_title"));
		$article->article_description = ucfirst($request->input("article_description"));
		$article->active_flag = $request->input("active_flag");
		$article->author_id = $request->user()->id;

		$article->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The article \"<a href='articles/$article->article_title'>" . $article->name . "</a>\" was Updated.");

		return redirect()->route('articles.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Article $article)
	{
		$article->active_flag = 0;
		$article->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The article ' . $article->name . ' was De-Activated.');

		return redirect()->route('articles.index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(Article $article,$id)
	{

		$article = Article::findOrFail($id);
		$article->active_flag = 1;
		$article->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The article ' . $article->name . ' was Re-Activated.');

		return redirect()->route('articles.index');
	}
	public function metatag(Request $request, $id){

		

		$meta = Article::findOrFail($id);
		$meta->meta_title = $request->input("meta_title");
		$meta->meta_keywords = $request->input("meta_keywords");
		$meta->meta_description = $request->input("meta_description");
		$meta->og_title = $request->input("meta_title");
		$meta->og_description = $request->input("meta_description");
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
		Session::flash('message', 'The article ' . $meta->meta_title . ' Metatags was added.');

		return redirect()->back();
	}
}

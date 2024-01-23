<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use \DB;

use App\Tender;
use Illuminate\Http\Request;
use \Session;

class TenderController extends Controller
{
	protected $model;

	public function __construct(Tender $model)
	{
		$this->model = $model;
		$this->middleware('auth');
	}

	 public function index(Request $request)
    {
       	if($request->get('search')){
		$search = \Request::get('search'); 
 		$tenders = Tender::where('title', 'like', '%'.$search.'%')->paginate(20);
   		 }else{
   			$tenders = Tender::orderBy('id', 'desc')->paginate(10);
		 }
		$active = Tender::where('active_flag', 1);
		return view('tenders.index', compact('tenders', 'active'));
    }

	public function create()
	{
			$countries = DB :: table('countries')->pluck('country_name','id');
	    return view('tenders.create',compact('countries'));
	}
	public function store(Request $request, User $user)
	{
		$tender = new Tender();

		request()->validate([
			'title' => 'required|max:255' ]);
		
		
	   	//$tender->category_id = $request->input("category_id");
	   	$tender->country_id = $request->input("country_id");
	   	//$tender->tender_notice_type = $request->input("tender_notice_type");
	   	$tender->title = $request->input("title");//
	   	$tender->issuer = $request->input("issuer");
	   	$tender->tender_reference = $request->input("tender_reference");
	   	//$tender->sector = $request->input("sector");
	   	$tender->closing_date = $request->input("closing_date");
	   	$tender->action_deadline = $request->input("action_deadline");
		$tender->issue_date = ucfirst($request->input("issue_date"));
		$tender->region = ucfirst($request->input("region"));
		//$tender->meeting_compulsary = ucfirst($request->input("meeting_compulsary"));
		//$tender->meeting_date = ucfirst($request->input("meeting_date"));
		$tender->tender_url = str_slug($request->input("tender_url"), "-");
		$tender->home_title = ucfirst($request->input("home_title"));
		$tender->home_description = ucfirst($request->input("home_description"));
		$tender->description = ucfirst($request->input("description"));
		
		$tender->active_flag = $request->input("active_flag");
		$tender->author_id = $request->user()->id;

		$tender->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The tender \"<a href='tenders/$tender->title'>" . $tender->name . "</a>\" was Created.");

		return redirect()->route('tenders.index');
	}

	public function show(Tender $tender)
	{
		//$tender = $this->model->findOrFail($id);

		return view('tenders.show', compact('tender'));
	}
	public function edit(Tender $tender)
	{
		$countries = DB :: table('countries')->pluck('country_name','id');	
		return view('tenders.edit', compact('tender','countries'));
	}

	public function update(Request $request, Tender $tender, User $user)
	{
		request()->validate([
			'title' => 'required|max:255' ]);
		
		
	   	//$tender->category_id = $request->input("category_id");
	   	$tender->country_id = $request->input("country_id");
	   	//$tender->tender_notice_type = $request->input("tender_notice_type");
	   	$tender->title = $request->input("title");
	   	$tender->issuer = $request->input("issuer");
	   	$tender->tender_reference = $request->input("tender_reference");
	   	$tender->action_deadline = $request->input("action_deadline");
	   	//$tender->sector = $request->input("sector");
	   	$tender->closing_date = ucfirst($request->input("closing_date"));
		$tender->issue_date = ucfirst($request->input("issue_date"));
		$tender->region = ucfirst($request->input("region"));
		//$tender->meeting_compulsary = ucfirst($request->input("meeting_compulsary"));
		//$tender->meeting_date = ucfirst($request->input("meeting_date"));
		$tender->tender_url = str_slug($request->input("tender_url"), "-");
		$tender->home_title = ucfirst($request->input("home_title"));
		$tender->home_description = ucfirst($request->input("home_description"));
		$tender->description = ucfirst($request->input("description"));
		
		$tender->active_flag = $request->input("active_flag");
		$tender->author_id = $request->user()->id;

		$tender->save();

		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The tender \"<a href='tenders/$tender->title'>" . $tender->name . "</a>\" was Updated.");

		return redirect()->route('tenders.index');
	}
	public function destroy(Tender $tender)
	{
		$tender->active_flag = 0;
		$tender->save();

		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The tender ' . $tender->name . ' was De-Activated.');

		return redirect()->route('tenders.index');
	}

	public function reactivate(Tender $tender,$id)
	{

		$tender = Tender::findOrFail($id);
		$tender->active_flag = 1;
		$tender->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The tender ' . $tender->name . ' was Re-Activated.');

		return redirect()->route('tenders.index');
	}
	public function metatag(Request $request,$id)
	{

		$meta = Tender::findOrFail($id);
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
		Session::flash('message', 'The Tenders ' . $meta->meta_title . ' Metatags was added.');


		return redirect()->route('tenders.index');
	}
}

<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TweetController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var tweet
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Tweet $model)
	{
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tweets = $this->model->paginate();

		return view('tweets.index', compact('tweets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tweets.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$inputs = $request->all();
		$this->model->create($inputs);

		return redirect()->route('admin.tweets.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tweet = $this->model->findOrFail($id);
		
		return view('tweets.show', compact('tweet'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tweet = $this->model->findOrFail($id);
		
		return view('tweets.edit', compact('tweet'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$inputs = $request->all();

		$tweet = $this->model->findOrFail($id);		
		$tweet->update($inputs);

		return redirect()->route('admin.tweets.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->model->destroy($id);

		return redirect()->route('admin.tweets.index')->with('message', 'Item deleted successfully.');
	}
}
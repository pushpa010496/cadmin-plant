<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Productlaunch;
use App\User;
use Auth;
use \Session;

class ProductlaunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $model;

    public function __construct(Productlaunch $model)
    {
        $this->model = $model;
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if($request->get('search')){
        $search = \Request::get('search'); 
        $projects = Productlaunch::where('title', 'like', '%'.$search.'%')->paginate(20);
         }
         else{
           $projects = Productlaunch::orderBy('id', 'desc')->paginate(10);
         }
        $active = Productlaunch::where('active_flag', 1);
        return view('productlaunch.index', compact('projects', 'active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productlaunch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       


       $productlaunch = new Productlaunch();

        request()->validate([
            'title' => 'required',
            'image' => 'required'
        ]);
        
        if($request->file('image')){

         $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());
        request()->image->move(public_path('productlaunch'), $imageName);
        $productlaunch->image = $imageName;   

        }
        
        $productlaunch->date = $request->input("date");
        $productlaunch->country = $request->input("country");

        //$project->category_id = $request->input("category_id");
       /* $project->company = $request->input("company");
        //$project->type = $request->input("type");
        $project->cost = $request->input("cost");
        $project->source = $request->input("source");
        */

        $productlaunch->title = ucfirst($request->input("title"));
        $productlaunch->img_title = ucfirst($request->input("img_title"));
        $productlaunch->img_alt = ucfirst($request->input("img_alt"));
        $productlaunch->location = ucfirst($request->input("location"));
        //$project->commencement = ucfirst($request->input("commencement"));
        $productlaunch->project_url = str_slug($request->input("project_url"), "-");
        $productlaunch->home_title = ucfirst($request->input("home_title"));
        $productlaunch->home_description = ucfirst($request->input("home_description"));
        $productlaunch->description = ucfirst($request->input("description"));
        
        $productlaunch->active_flag = $request->input("active_flag");
        $productlaunch->author_id = $request->user()->id;

        $productlaunch->save();

        Session::flash('message_type', 'success');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The product luanch successfully Created.");

        return redirect()->route('productlaunch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Productlaunch $Productlaunch)
    {
        return view('productlaunch.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Productlaunch $productlaunch)
    {
        $project=$productlaunch;
        //return $project=Productlaunch::first();
        return view('productlaunch.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Productlaunch $productlaunch,User $user)
    {
        $project= $productlaunch;
        request()->validate([
            'title' => 'required|max:255',
           
        ]);
        
        if($request->file('image')){
        $path = public_path('productlaunch');
        $imageName = preg_replace('/\s+/', '-', time().'-'.$request->file('image')->getClientOriginalName());        
         if(request()->image->move($path, $imageName)){
                if(\File::exists($path.'/'.$project->image)){                   
                    \File::delete($path.'/'.$project->image);                           
                }           
            }
        $project->image = $imageName;   
        }
        
        $project->date = ucfirst($request->input("date"));
        $project->title = ucfirst($request->input("title"));
        //$project->category_id = $request->input("category_id");
        $project->country = $request->input("country");
       // $project->company = $request->input("company");
        //$project->type = $request->input("type");
        //$project->cost = $request->input("cost");
       // $project->source = $request->input("source");
        $project->img_title = ucfirst($request->input("img_title"));
        $project->img_alt = ucfirst($request->input("img_alt"));
        $project->location = ucfirst($request->input("location"));
        //$project->commencement = ucfirst($request->input("commencement"));
        $project->project_url = str_slug($request->input("project_url"), "-");
        $project->home_title = ucfirst($request->input("home_title"));
        $project->home_description = ucfirst($request->input("home_description"));
        $project->description = ucfirst($request->input("description"));
        
        $project->active_flag = $request->input("active_flag");
        $project->author_id = $request->user()->id;


        $project->save();

        Session::flash('message_type', 'warning');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', "The project \"<a href='projects/$project->title'>" . $project->name . "</a>\" was Updated.");

        return redirect()->route('productlaunch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function destroy(Productlaunch $productlaunch)
    {
        $productlaunch->active_flag = 0;
        $productlaunch->save();

        Session::flash('message_type', 'danger');
        Session::flash('message_icon', 'hide');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The project ' . $productlaunch->name . ' was De-Activated.');

        return redirect()->route('productlaunch.index');
    }

    public function reactivate(Productlaunch $productlaunch,$id)
    {

        $productlaunch = Productlaunch::findOrFail($id);
        $productlaunch->active_flag = 1;
        $productlaunch->save();

        Session::flash('message_type', 'success');
        Session::flash('message_icon', 'checkmark');
        Session::flash('message_header', 'Success');
        Session::flash('message', 'The project ' . $productlaunch->name . ' was Re-Activated.');

        return redirect()->route('productlaunch.index');
    }
}

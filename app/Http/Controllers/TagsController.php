<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Http\Request;
use App\Category;
use \Session;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('search')){
        $search = \Request::get('search');
            $tags = Tags::where('tag_name', 'like', '%'.$search.'%')
            ->where('tag_name', 'like', '%'.$search.'%')
            ->paginate(20);
        $tags->appends(['search' => $search]);
         }else{
            $tags = Tags::orderBy('id', 'desc')->paginate(10);
         }
    
        $active = Tags::where('active_flag', 1);
   
         return view('tags.index',compact('tags'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category_list = Category::where('active_flag',1)->where('parent_id','!=','22')->pluck('name','id');
        return view('tags.create',compact('category_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $cat_id=$request->input("category_id");
        $tag_name=$request->input("tag_name");
     $checktag= Tags::where('category_id',$cat_id)->where('tag_name',$tag_name)->count();
        if ($checktag == 0) {

                $tags=new Tags();
                $tags->category_id = $request->input("category_id");
                $tags->tag_name = ucfirst($request->input("tag_name"));
                $tags->active_flag = $request->input("active_flag"); 
                $tags->save();

                $category = Category::find($request->input("category_id"));
                $tags->categories()->sync($category);

                return redirect()->back();
         
        
        }else{
             $category_list = Category::where('active_flag',1)->where('parent_id','!=','22')->pluck('name','id');
            return redirect()->back()->with('message', 'Tag already there');
         
                //
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show(Tags $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit(Tags $tag)
    {
        $category_list = Category::where('active_flag',1)->where('parent_id','!=','22')->pluck('name','id');

        return view('tags.edit',compact('category_list','tag'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tags $tag)
    {
       
        $tag->category_id = $request->input("category_id");
        $tag->tag_name = ucfirst($request->input("tag_name"));
        $tag->active_flag = $request->input("active_flag");
        $tag->save();

        $category = Category::find($request->input("category_id"));
        $tag->categories()->sync($category);

        return redirect()->route('tags.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags)
    {
        //
    }
     


}

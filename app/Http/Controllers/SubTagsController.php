<?php

namespace App\Http\Controllers;

use App\SubTags;
use Illuminate\Http\Request;
use App\Tags;
use App\Category;
use App\Product;
use \Session;

class SubTagsController extends Controller
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
            $subtags = SubTags::where('subtag_name', 'like', '%'.$search.'%')
            ->where('subtag_name', 'like', '%'.$search.'%')
            ->paginate(20);
        $subtags->appends(['search' => $search]);
         }else{
            $subtags = SubTags::orderBy('id', 'desc')->paginate(10);
         }
    
        $active = SubTags::where('active_flag', 1);
   
  
         return view('subtags.index',compact('subtags'));
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
         $tags=Tags::where('active_flag',1)->pluck('tag_name','id');

        return view('subtags.create',compact('category_list','tags'));
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
        $product_id=$request->input("ajax_id");
        $tag_id=$request->input("tag_id");
  
         $subtags=new SubTags();
       
        $subtags->category_id = $request->input("category_id");
        $subtags->tag_id = ucfirst($request->input("tag_id"));
        $subtags->product_id = ucfirst($request->input("ajax_id"));
         $subtags->subtag_name = ucfirst($request->input("subtag_name"));
        $subtags->active_flag = 1;
        $subtags->save();

         $product = Product::find($request->ajax_id);
        $subtags->products()->sync($product);

         return redirect()->back();

        
        return redirect()->route('subtags.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubTags  $subTags
     * @return \Illuminate\Http\Response
     */
    public function show(SubTags $subTags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubTags  $subTags
     * @return \Illuminate\Http\Response
     */
    public function edit(SubTags $subtag)
    {
        //
        $category_list = Category::where('active_flag',1)->where('parent_id','!=','22')->pluck('name','id');
         $tags=Tags::where('active_flag',1)->pluck('tag_name','id');

        return view('subtags.edit',compact('category_list','tags','subtag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubTags  $subTags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubTags $subtag)
    {
        //
      
         $subtag->category_id = $request->input("category_id");
        $subtag->tag_id = ucfirst($request->input("tag_id"));
         $subtag->subtag_name = ucfirst($request->input("subtag_name"));
        $subtag->active_flag = $request->input("active_flag");
        $subtag->save();
         return redirect()->route('subtags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubTags  $subTags
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubTags $subTags)
    {
        //
    }

  /*  public function ajaxcategory($id){
       $categories= Tags::where('category_id',$id);

        $tags=$categories->pluck('id','tag_name');
       foreach ($tags as $key => $value) {
         echo '<option value="'.$value.'">'.$key.'</option>';    
          
       }

    }*/

       public function ajaxcategory(Request $request,$product_id){


       return  $category_list=SubTags::where('product_id',$product_id)->where('category_id',$request->category_id)->where('tag_id',$request->tag_id)->count();

      // return $categories= SubTags::where('category_id',$category_id)->where('tag_id',$tag_id)->get();

      /*  $tags=$categories->pluck('id','tag_name');
       foreach ($tags as $key => $value) {
         echo '<option value="'.$value.'">'.$key.'</option>';    
          
       }*/

    }

   public function slugconvert(Request $request){

         $slug_list=SubTags::select('subtag_name')->get();

            foreach($slug_list as $slug){
                $tag = str_slug($slug->subtag_name, "-");
                $test=\DB::table('sub_tags')->where('subtag_name',$slug->subtag_name)->update(['slug'=>$tag]);
            }

    }
      
}

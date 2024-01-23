<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductNewsletter extends Controller
{
    public function index()
    {
        return view('productnewsletter.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             
              $category=$request->input('category');
              $title=$request->input('imgtitle');
              $file = Input::file('image');

              $folder="";

              if ($category =="articles") {
                     $folder="productnewsletter";
                } 
          else {

            $folder="";
   
                }
             // print_r($file->getClientsize()); die;
            // image upload in public/upload folder.

                $orfilename=strtolower($file->getClientOriginalName());

                $filenamee = preg_replace('/\s+/', '-', $orfilename);

               $filename=preg_replace('/[^A-Za-z0-9\-.]/', '', $filenamee); // Removes special chars.


               // $filename = str_slug($orfilename);
                
                   $imagepath=$folder."/"."images/";

                  


            
                    
              $dataupload=$file->move(public_path($imagepath),$filename); 
            // LOWER($filename);
            if($dataupload){

             $livelink="https://industry.plantautomation-technology.com/".$imagepath.$filename;
                }
               
           return view('productnewsletter.create',compact('livelink'));

                 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

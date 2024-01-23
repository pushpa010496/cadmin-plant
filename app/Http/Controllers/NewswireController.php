<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Xmlpharse;

class NewswireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news=Xmlpharse::take(10)->get();

        print_r($news); die;
       
        return view('newswires.index',compact('news'));
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
        //
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

    public function morenews(Request $request,$type)
    {

      if($type=="bnw"){ $type="bussinesswire";}
        elseif($type=="pnw"){$type="prnews";}
            else{ $type="globalnews";}
      $news=Xmlpharse::where('type',$type)->get();

     return view('newswires.allnews',compact('news'));
    }

    public function newsview(Request $request,$type,$id)
    {

     $news=Xmlpharse::where('id',$id)->get();

     

     return view('newswires.newsview',compact('news'));

    }

}

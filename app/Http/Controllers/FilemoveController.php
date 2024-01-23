<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

use App\CompanyProfile;

use Illuminate\Support\Facades\Input;

use File;

use App\Company;

use App\CompanyVideo;

use App\CompanyCatalog;

use App\CompanyPressrealese;


use App\CompanyWhitePaper;

class FilemoveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('filemove.create');
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
        //$companyid=$request->input('company');


         $company=Company::select('id')->get();

      


         foreach($company as $cmp){

          $companyid=$cmp->id;

         // $companyid='23';

         

         $company_info=CompanyProfile::where('company_id',$companyid)->get();


        foreach($company_info as $cmp_info){



           // $path = public_path().'/suppliers/' . $cmp_info->url."/products";

          // $path = public_path().'/suppliers/' . $cmp_info->url;

           //$path = public_path().'/suppliers/' . $cmp_info->url."/video";
              $path = public_path().'/suppliers/' . $cmp_info->url."/pressrealese";
           //$path = public_path().'/suppliers/' . $cmp_info->url."/whitepaper";

           //$path = public_path().'/suppliers/' . $cmp_info->url."/catalog";

           

           File::makeDirectory($path, $mode =777, true,true);

        }

      
   // file_exists(public_path().'/'.$imagepath.$filename)



 //     $product_info=Product::where('company_id',$companyid)->get();
        
 //        foreach($product_info as $info){

 //               $bigimage=$info->big_image;

 //               $smallimage=$info->small_image;



 //    if(file_exists(public_path().'/products/'.$bigimage)){

 //        $oldpath=public_path().'/products/'.$bigimage;
 //        $newpath=$path."/".$bigimage;
 //        File::move($oldpath, $newpath);

 // }
 

 //    if(file_exists(public_path().'/products/'.$smallimage)){

 //        $oldpath=public_path().'/products/'.$smallimage;
 //        $newpath=$path."/".$smallimage;
 //        File::move($oldpath, $newpath);

 //   }
 
 //             }



             /* Code for Videos Move */

//                 $video_info=CompanyVideo::where('company_id',$companyid)->get();

// 			    foreach($video_info as $info){

// 			    echo $video=$info->video;

// 			    if(file_exists(public_path().'/company/'.'video/'.$video)){

// 		    	echo $oldpath=public_path().'/company/'.'video/'.$video;

// 		    	echo $newpath=$path."/".$video;

//                 File::move($oldpath, $newpath);
                   
// }

//    }
/* Code for Videos Move */


/* Code for logos Move */

//                 $datata=Company::select('comp_logo')->get();

//                $datata= Company::where('id',$companyid)->get();

// 			   foreach($datata as $info){

// 			    $logo=$info->comp_logo;

//                  if(file_exists(public_path()."/company/".$logo)){
      

// 		             $oldpath=public_path()."/company/".$logo;
		
//                      $newpath=$path."/".$logo;

//                      File::move($oldpath, $newpath);
//                    echo $oldpath=public_path()."/company/".$logo."<br>";
		
//                      echo $newpath=$path."/".$logo."<br>";


// }
//    }
/* EndCode for logos Move */


/* Code for pressrealese Move */

                // $datata= CompanyPressrealese::Where('company_id',$companyid)->where('image','!=','')->where('pdf','!=','')->where('company_id','!=','')->get();

                 $datata= CompanyPressrealese::Where('company_id',$companyid)->get();
 
           


                  foreach($datata as $info){

			       $image=$info->image;

			        $pdf=$info->pdf;

                    if(file_exists(public_path()."/company/pressrealese/".$image)){
                     
                     
                     echo  $oldpath=public_path()."/company/pressrealese/".$image;
		
                      echo $newpath=$path."/".$image;
                           if($image){

                           	File::move($oldpath, $newpath);
                           }
                           else{
                           	echo"Aaaa";
                           }
                     
                    
                     }

               if(file_exists(public_path()."/company/pressrealese/".$pdf)){
                     
                    echo  $oldpath=public_path()."/company/pressrealese/". $pdf;
		
                     echo $newpath=$path."/".$pdf;
                             if($pdf){

                           	File::move($oldpath, $newpath);
                           }
                            else{
                           	echo"Aaaa";
                           }
                   
                     }

                     

             




  }
/* EndCode for pressrealese Move */



/* Code for whitepapers Move */


//                 $whitepaper_info=CompanyWhitePaper::where('company_id',$companyid)->get();

// 			    foreach($whitepaper_info as $info){

// 			      $image=$info->image;

// 			      $pdf=$info->pdf;

// 			    if(file_exists(public_path().'/company/'.'whitepaper/'.$image)){

// 		    	echo $oldpath=public_path().'/company/'.'whitepaper/'.$image;

// 		    	echo $newpath=$path."/".$image;
//                 if($image){
// 	                File::move($oldpath, $newpath);
//                 }
//                 else{

//      	         echo "AaaaA";
//                      }           
                   
// }

// if(file_exists(public_path().'/company/'.'whitepaper/'.$pdf)){

// 		    	echo $oldpath=public_path().'/company/'.'whitepaper/'.$pdf;

// 		    	echo $newpath=$path."/".$pdf;
//                 if($pdf){
// 	                File::move($oldpath, $newpath);
//                 }
//                 else{

//      	         echo "AaaaA";
//                      }           
                   
// }

//    }



/* EndCode for whitepapers Move */



/* Code for Catalogues Move */

              

                 $datata= CompanyCatalog::Where('company_id',$companyid)->where('active_flag',1)->get();
                // print_r($datata);

			     foreach($datata as $info){

			      $catalogues=$info->image;

			      $catalogues1=$info->pdf;

                    if(file_exists(public_path()."/company/catalog/".$catalogues)){
                     
                     $oldpath=public_path()."/company/catalog/".$catalogues;
		
                     $newpath=$path."/".$catalogues;

                     File::move($oldpath, $newpath);
                     }
                if(file_exists(public_path()."/company/catalog/".$catalogues1)){
                     
                     $oldpath=public_path()."/company/catalog/". $catalogues1;
		
                     $newpath=$path."/".$catalogues1;

                     File::move($oldpath, $newpath);
                     }

                     echo $oldpath=public_path()."/company/catalog/". $catalogues1;
		
                     echo $newpath=$path."/".$catalogues1;


   }
/* End Code for Catalogues Move */




    }    
exit;
        
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

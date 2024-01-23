<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Category;
use Illuminate\Filesystem\Filesystem;
use Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use ZipArchive;
use File;
use Auth;
use App\User;
use \Session;
use DB;
use App\CompanyProfile;
use App\Product;
use App\Tracklink;


class bulkCompanyController extends Controller
{
 protected $model;

 protected $not_found_docs =[];
 protected $i= 0;

 protected $links =[];
 protected $link_count = 0;

 protected $array_count= 0;
 protected $error= 0;

 protected $new_cpm = '';

  protected $old_cpm = '';

 public function __construct(Product $model)
 {

    $this->middleware('auth');
    $this->model = $model;

}



public function index()
{        
    // return Company::all();   
    return view('bulkUpload.index');
}

//bulkData method
public function bulkData(Request $request)
{        
    if($request->file('companiesfile')){   
        $filename = $request->file('companiesfile')->getClientOriginalName();
        $folderName = pathinfo($filename, PATHINFO_FILENAME);

        $moveFile = request()->companiesfile->move(public_path('bulkupload/companieslot'), $filename);
         $path = public_path('bulkupload/companieslot/'.$filename);  
        // chmod($path, 0755);
      
        \Zipper::make($path)->extractTo(public_path('bulkupload/unzipcompanies'));
        $folderList = glob(public_path('bulkupload/unzipcompanies').'/*',GLOB_ONLYDIR);
        


       \File::cleanDirectory(public_path('bulkupload/companieslot/'));
        // exec('rm -r ' . public_path('bulkupload/companieslot/'));
        foreach($folderList as $filess){  

            $companyName =  basename($filess); 
            $chmloc = public_path('bulkupload/unzipcompanies').'/'.$companyName;

            // chmod($chmloc, 0755);                

            $this->validations($companyName);  
        }
       
        if($this->error  == 1){
            $errors = $this->not_found_docs;
            // return $errors[3];
             \File::cleanDirectory(public_path('bulkupload/unzipcompanies/'));
            return  view('bulkUpload.show',compact('errors'));
        
        }else{
            // return 'Awesome.... Everything is good, you can proceed to upload.';
            foreach($folderList as $filess){     
                $companyName =  basename($filess);
                $this->old_cpm = basename($filess);

                $this->createCompany($companyName);
               
                $this->dataStore($this->new_cpm, $companyName);
                $cmp_path =  public_path('bulkupload/unzipcompanies/'.$companyName);
                // \File::deleteDirectory($cmp_path);
            }
        }
         $livelinks = $this->links;
             \File::cleanDirectory(public_path('bulkupload/unzipcompanies/'));
    return  view('bulkUpload.create',compact('livelinks'));
    return 'Success';   
    }
    return 'nothing';
}
//End bulkData method

//File permissions


//end File permissions

//createCompany method
public function createCompany($companyName){
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$companyName);


    $sheet = $companyFolderPath.'/data.xlsx';
    if(file_exists($sheet)){       
        $companyData = Excel::selectSheets('company')->load($sheet)->get();
        if($companyData->count() != ""){
            foreach ($companyData as $key => $value) {                               
                if($value->name != ''){

                     $company = new Company;     
                     $company->comp_name = $value->name;     
                     $company->contact_name = ucfirst($value->contact_name);      
                     $company->email = str_replace(' ', '', $value->email);
                     $company->phone = $value->phone;
                     $company->start_date = date("Y-m-d H:i:s",strtotime($value->start_date));
                     $company->end_date = date("Y-m-d H:i:s",strtotime($value->end_date));    
                     $company->country = trim($value->country, " \t.");
                     $company->website = $value->website;
                       // $company->website = isset($value->website) ? $this->urlTrack($value->website) : '';
                     $company->comp_logo = $value->logo;
                     $company->fax = $value->fax;   
                     $company->address = $value->address;
                     $company->active_flag = 0;
                     $company->profile_type = isset($value->profile_type) ? $value->profile_type : 'blind';
                     $company->author_id = \Auth::user()->id;
                     $company->save();
                       $company->website = isset($value->website) ? $this->urlTrack($company->id,$value->website) : '';
                     if($value->logo != ''){
                        $this->companyLogo($company->id,$companyName);
                     }
                       // $company->logo = isset($company->id,$value->logo) ? $this->companyLogo($company->id,$value->logo) : '';
                     $role = 6;
                     $user = new User();
                     $user->name = $value->name;
                     $user->email = str_replace(' ', '', $value->email);
                     $user->password = Hash::make('123456');
                     $user->active_flag = 1;
                     $user->save();
                     $user->attachRole($role);

                    $this->createCompanyProfile($company->id);
                }
            }          
            return true;
        }
    }
    else {
        return false;
    }
}
//End createCompany method
//companyLogo method
public function companyLogo($company,$companyName){
    $company = Company::find($company);
    
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$companyName.'/cropped/'.$company->comp_logo.'.jpg');
    chmod($companyFolderPath, 0755);   

    if($companyFolderPath){
        $location = public_path('suppliers').'/'.str_slug($company->comp_name);
       

        if(File::exists($location)) {            
            chmod($location, 0755);   
        }else{
              File::makeDirectory($location, $mode =0755, true,true);
            // mkdir($location); 
            // chmod($location, 777);   
        }        

        $imageName= date('Ymdhis').rand().'.jpg';   

        copy($companyFolderPath,$location.'/'.$imageName);

        // $success = File::move($companyFolderPath,$location.'/'.$imageName); 
        $company->comp_logo = $imageName;   
        $company->save();
    }
    return true;
}
//End companyLogo method

//createCompanyProfile method
public function createCompanyProfile($company){
    $company = Company::find($company);

    $this->new_cpm = $company->comp_name;
        // $comp = $company->id;
        // $company = Company::where('id',$comp)->select('comp_name')->first();       
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$this->old_cpm);
    $sheet = $companyFolderPath.'/data.xlsx';

    // if(file_exists($sheet)){       
    //     $companyData = Excel::selectSheets('profile')->load($sheet)->get();


        // if($companyData->count() != ""){
        //     foreach ($companyData as $key => $value) {                 
        //         if($value->status != ''){
        //             $companyp = new CompanyProfile();                        
        //             $companyp->title = ucfirst($company->comp_name);
        //             $companyp->meta_keywords = $company->comp_name;
        //             $companyp->meta_title = ''.$company->comp_name.' | Plant automation-technology';        
        //             $companyp->og_title = ''.$company->comp_name.' | Plant automation-technology';      
        //             $companyp->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$company->comp_name.'';
        //             $companyp->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$company->comp_name.'';
        //             $companyp->og_keywords = $company->comp_name;
        //             $companyp->og_image = str_slug($company->comp_name);       
        //             $companyp->url = str_slug($company->comp_name);      
        //             $companyp->company_id = $company->id;                             
        //             $companyp->active_flag = $value->status;
        //             $companyp->author_id = \Auth::user()->id;
        //             $comp = Company::find($company->id);
        //             $comp->companyprofile()->save($companyp);
        //             $this->profileDescription($companyp->id);
        //         }
        //     }          
        //     return true;
        // }
    // }
        $companyp = new CompanyProfile();                        
        $companyp->title = ucfirst($company->comp_name);
        $companyp->meta_keywords = $company->comp_name;
        $companyp->meta_title = ''.$company->comp_name.' | Plant automation-technology';        
        $companyp->og_title = ''.$company->comp_name.' | Plant automation-technology';      
        $companyp->meta_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$company->comp_name.'';
        $companyp->og_description = 'suppliers and manufacturers of the '.$company->comp_name .' provide high quality products such as '.$company->comp_name.'';
        $companyp->og_keywords = $company->comp_name;
        $companyp->og_image = str_slug($company->comp_name);       
        $companyp->url = str_slug($company->comp_name);      
        $companyp->company_id = $company->id;                             
        $companyp->active_flag = 0;
        $companyp->author_id = \Auth::user()->id;
        $comp = Company::find($company->id);
        $comp->companyprofile()->save($companyp);
        $this->profileDescription($companyp->id);
    
        $m = $this->link_count;        
        $this->links[$m]['live'] = 'https://www.plantautomation-technology.com/suppliers/'. $companyp->url;
        $this->links[$m]['test'] =  'https://www.plantautomation-technology.com/testsuppliers/'. $companyp->url;
        $this->link_count = $m +1;

}
//End createCompanyProfile method

//profileDescription method
public function profileDescription($profileid){
    $profile = CompanyProfile::find($profileid);

    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$this->old_cpm);

    if(File::exists($companyFolderPath.'/profile.docx')){

        $file = $companyFolderPath.'/profile.docx';
        try {

            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);

        } catch (\Exception $e) {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file, 'MsDoc');
        }
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $tmpfname = public_path('bulkupload/doczipfiles/temp.html','HTML');
        $htmlWriter->save($tmpfname);

        $html = file_get_contents($tmpfname);
        libxml_use_internal_errors(true); 
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $body = "";
        foreach($dom->getElementsByTagName("body")->item(0)->childNodes as $child) {
            $body .= $dom->saveHTML($child);
        }

        $profile->description = $body;
        $profile->save();

            // $product_doc = DB::table('temp_products')->where('id',$value->id)->update(['description'=>$body]);
        unlink($tmpfname);
    }
    return true;
}
//End profileDescription method

//track url
public function urlTrack($company, $website)
{
      $company = Company::find($company);

    if($website !=""){
        $tracklink = Tracklink::on('mysql2')->find($company->track_id);
        if(empty($tracklink)){
                    // create short link

            $tracklinks = new Tracklink();
            $tracklinks->setConnection('mysql2');

            $tracklinks->type =  "company";
            $tracklinks->title =  $company->comp_name;
            $tracklinks->oriurl =  $company->website;
            $tracklinks->shorturl_id =  date('Ymdhis').rand();
            $tracklinks->titleid =  rand();
            $tracklinks->save();

            $track_url = 'http://track.plantautomation-technology.com/'.$tracklinks->shorturl_id;
            $company->track_url = $track_url;
            $company->track_id = $tracklinks->id;
            $company->save();
            //end short link

        }else{
        return false;
            // $tracklink->setConnection('mysql2');
            $tracklink->oriurl =  $company->website;
            $tracklink->save();
            
        }

    }
    return true;
       
}
//track URL end

//Data Storing
public function dataStore($companyName,$folder){
    $user = \Auth::user();
    $comp = Company::where('comp_name',$companyName)->first();
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$this->old_cpm);
    $path =$companyFolderPath.'/data.xlsx';

    //Products
    $company_products = Excel::selectSheets('products')->load($path)->get(); 
    $company_press = Excel::selectSheets('pressrealeses')->load($path)->get();   
    $company_whitepapers = Excel::selectSheets('whitepapaers')->load($path)->get();
    $company_catalogs = Excel::selectSheets('catalog')->load($path)->get();
    $company_videos = Excel::selectSheets('videos')->load($path)->get();

    if($company_products->count()){
        foreach ($company_products as $key => $value) {

            $category = Category::where('name',trim($value->category_id))->get();

            if(count($category) === 0){
                $category_id = 22;

            }else{
             $category_id = $category->first()->id;
            }

            if($value->tech_spec_pdf != ''){
                $value->tech_spec_pdf = str_slug($value->tech_spec_pdf).'.pdf';
            }

            if($value->title != ''){

               $product_arr[] = [
                'company_id' => $comp->id, 
                'company_profile_id' => $comp->companyprofile->first()->id,
                'category_name'=>$value->category_id,
                'category_id'=>$category_id,                                                
                'title'=>$value->title,
                'type' => 'client', 
                'small_image' => str_slug($value->small_image).'.jpg',
                'big_image'=>str_slug($value->big_image).'.jpg',
                'alt_tag'=>$value->alt_tag,
                'title_tag' => $value->title_tag, 
                'doc_file' => str_slug(trim($value->doc_file, " \t.")).'.docx',
                'description'=> $this->docConverter($comp->comp_name,str_slug(trim($value->doc_file, " \t.")).'.docx',$this->old_cpm),
                'googleplus'=>$value->googleplus,
                'linkedin'=>$value->linkedin,
                'facebook'=>$value->facebook,
                'twitter'=>$value->twitter,
                'keyword1'=>$value->keyword1,
                'keyword2'=>$value->keyword2,
                'keyword3'=>$value->keyword3,
                'keyword4'=>$value->keyword4,
                'keyword5'=>$value->keyword5,                       
                'tech_spec_pdf'=> str_slug(trim($value->tech_spec_pdf, " \t.")).'.pdf',
                'url'=>str_slug($value->url),
                'active_flag'=>0,
                'stage'=>0,
                'meta_title'=>$value->meta_title,
                'meta_keywords'=>$value->meta_keywords,
                'meta_description'=>$value->meta_description,
                'og_title'=>$value->og_title,
                'og_description'=>$value->og_description,
                'og_keywords'=>$value->og_keywords,
                'og_image'=>$value->og_image,
                'og_video'=>$value->og_video,
                'meta_region'=>$value->meta_region,
                'meta_position'=>$value->meta_position,
                'meta_icbm'=>$value->meta_icbm,
                'author_id'=> $user->id];
            }
        }               
        if(!empty($product_arr)){
            \DB::table('products')->insert($product_arr);
            $this->imageUpload($comp->comp_name,'products',$this->old_cpm);
        }
    }

    //press releases
    if($company_press->count()){
        foreach ($company_press as $key => $value) {
            if($value->title != ''){
             $press_arr[] = [
                'company_id' => $comp->id, 
                'company_profile_id' => $comp->companyprofile->first()->id,
                'title'=>$value->title,                        
                'image'=>str_slug($value->image).'.jpg',
                'type' => 'client',                        
                'alt_tag'=>$value->alt_tag,
                'title_tag' => $value->title_tag, 
                'pdf' =>str_slug(trim($value->pdf, " \t.")).'.pdf',
                'active_flag'=>0,
                'stage'=>0,
                'meta_title'=>$value->meta_title,
                'meta_keywords'=>$value->meta_keywords,
                'meta_description'=>$value->meta_description,
                'og_title'=>$value->og_title,
                'og_description'=>$value->og_description,
                'og_keywords'=>$value->og_keywords,
                'og_image'=>$value->og_image,
                'og_video'=>$value->og_video,
                'meta_region'=>$value->meta_region,
                'meta_position'=>$value->meta_position,
                'meta_icbm'=>$value->meta_icbm,
                'author_id'=> $user->id];
            }

        }
        if(!empty($press_arr)){
            \DB::table('company_pressrealese')->insert($press_arr);
            $this->imageUpload($comp->comp_name,'pressrealese',$this->old_cpm);
        }
    }

    //White papers
    if($company_whitepapers->count()){
        foreach ($company_whitepapers as $key => $value) {
           if($value->title != ''){
             $whitepapers_arr[] = [
                'company_id' => $comp->id, 
                'company_profile_id' => $comp->companyprofile->first()->id,
                'title'=>$value->title,                        
                'image'=>str_slug($value->image).'.jpg',
                'type' => 'client',                        
                'alt_tag'=>$value->alt_tag,
                'title_tag' => $value->title_tag, 
                'pdf' =>str_slug(trim($value->pdf, " \t.")).'.pdf',       
                'active_flag'=>0,
                'stage'=>0,
                'meta_title'=>$value->meta_title,
                'meta_keywords'=>$value->meta_keywords,
                'meta_description'=>$value->meta_description,
                'og_title'=>$value->og_title,
                'og_description'=>$value->og_description,
                'og_keywords'=>$value->og_keywords,
                'og_image'=>$value->og_image,
                'og_video'=>$value->og_video,
                'meta_region'=>$value->meta_region,
                'meta_position'=>$value->meta_position,
                'meta_icbm'=>$value->meta_icbm,
                'author_id'=> $user->id];
            }
        }
        if(!empty($whitepapers_arr)){
            \DB::table('company_whitepapers')->insert($whitepapers_arr);
            $this->imageUpload($comp->comp_name,'whitepaper',$this->old_cpm);
        }
    }

    //Catalogues
    if($company_catalogs->count()){
        foreach ($company_catalogs as $key => $value) {
           if($value->title != ''){
             $catalogs_arr[] = [
                'company_id' => $comp->id, 
                'company_profile_id' => $comp->companyprofile->first()->id,
                'title'=>$value->title,                        
                'image'=>str_slug($value->image).'.jpg',
                'type' => 'client',                        
                'alt_tag'=>$value->alt_tag,
                'title_tag' => $value->title_tag, 
                'pdf' => str_slug(trim($value->pdf, " \t.")).'.pdf',                 
                'active_flag'=>0,
                'stage'=>0,
                'meta_title'=>$value->meta_title,
                'meta_keywords'=>$value->meta_keywords,
                'meta_description'=>$value->meta_description,
                'og_title'=>$value->og_title,
                'og_description'=>$value->og_description,
                'og_keywords'=>$value->og_keywords,
                'og_image'=>$value->og_image,
                'og_video'=>$value->og_video,
                'meta_region'=>$value->meta_region,
                'meta_position'=>$value->meta_position,
                'meta_icbm'=>$value->meta_icbm,
                'author_id'=> $user->id];
            }
        }
        if(!empty($catalogs_arr)){
            \DB::table('company_catalogs')->insert($catalogs_arr);
            $this->imageUpload($comp->comp_name,'catalog',$this->old_cpm);
        }
    }

    //Videos
    if($company_videos->count()){
        foreach ($company_videos as $key => $value) {
           if($value->title != ''){
             $videos_arr[] = [
                'company_id' => $comp->id, 
                'company_profile_id' => $comp->companyprofile->first()->id,
                'title'=>$value->title,                        
                'video'=>str_slug($value->video).'.mp4',
                'type' => 'client',                                                            
                'active_flag'=>0,
                'stage'=>0,
                'meta_title'=>$value->meta_title,
                'meta_keywords'=>$value->meta_keywords,
                'meta_description'=>$value->meta_description,
                'og_title'=>$value->og_title,
                'og_description'=>$value->og_description,
                'og_keywords'=>$value->og_keywords,
                'og_image'=>$value->og_image,
                'og_video'=>$value->og_video,
                'meta_region'=>$value->meta_region,
                'meta_position'=>$value->meta_position,
                'meta_icbm'=>$value->meta_icbm,
                'author_id'=> $user->id];
            }
        }
        if(!empty($videos_arr)){
            \DB::table('company_videos')->insert($videos_arr);
            $this->imageUpload($comp->comp_name,'video',$this->old_cpm);
            
        }
    }

    return true;
}
// End Data Storing

// Data convert method
public function docConverter($companyName, $fileName, $folder){
   $company = Company::where('comp_name',$companyName)->first();
   $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$this->old_cpm);

   $path_rename =$companyFolderPath.'/documents';
   $di = new \RecursiveIteratorIterator(
       new \RecursiveDirectoryIterator($path_rename, \FilesystemIterator::SKIP_DOTS),\RecursiveIteratorIterator::LEAVES_ONLY);
   foreach($di as $name => $fio) {
       $path_extension = pathinfo($fio)['extension'];
       $newname = $fio->getPath() . DIRECTORY_SEPARATOR . str_slug(pathinfo($fio,PATHINFO_FILENAME));
     //echo $newname, "\r\n";
       rename($name, $newname.'.'.$path_extension);
   }
   if(File::exists($companyFolderPath.'/documents/'.$fileName)){

    $file = $companyFolderPath.'/documents/'.$fileName;
    try {

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);

    } catch (\Exception $e) {
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file, 'MsDoc');
    }
    $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
    $tmpfname = public_path('bulkupload/doczipfiles/temp.html','HTML');
    $htmlWriter->save($tmpfname);

    $html = file_get_contents($tmpfname);
    libxml_use_internal_errors(true); 
    $dom = new \DOMDocument();
    $dom->loadHTML($html);
    $body = "";
    foreach($dom->getElementsByTagName("body")->item(0)->childNodes as $child) {
        $body .= $dom->saveHTML($child);
    }
    return $body;       
    unlink($tmpfname);
    }

}
// end Data convert method

//imageUpload method
public function imageUpload($companyName, $folderName,$filename){
   $company = Company::where('comp_name',$companyName)->first();
   $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$this->old_cpm);

   $path =$companyFolderPath.'/cropped/'.$folderName;
   $url = glob($companyFolderPath.'/cropped/'.$folderName.'/*' , GLOB_ONLYDIR);
   $slug = str_slug($companyName);

   \File::copyDirectory( $path,  public_path('suppliers').'/'.$slug.'/'.$folderName);

   $path_rename = public_path('suppliers').'/'.$slug.'/'.$folderName;
   $di = new \RecursiveIteratorIterator(
     new \RecursiveDirectoryIterator($path_rename, \FilesystemIterator::SKIP_DOTS),\RecursiveIteratorIterator::LEAVES_ONLY);
    foreach($di as $name => $fio) {
        $path_extension = pathinfo($fio)['extension'];
        $newname = $fio->getPath() . DIRECTORY_SEPARATOR . str_slug(pathinfo($fio,PATHINFO_FILENAME));                    
        rename($name, $newname.'.'.$path_extension);
    }

 return true;
}
//End imageUpload method


//Validations method
public function validations($companyName){
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$companyName);
    $path =$companyFolderPath.'/data.xlsx';

   
    // validations
    $company = Company::where('comp_name',$companyName)->first();
    $companyFolderPath = public_path('bulkupload/unzipcompanies/'.$companyName);
    $not_found_docs = $this->not_found_docs;
    $i= $this->i;
    
    $error= $this->error;
    



      if(File::exists($companyFolderPath.'/profile.docx')){
       }
       else{
       $this->error = 1;                   
       $this->not_found_docs[$i]['company'] = $companyName;
       $this->not_found_docs[$i]['profile'] = 'profile.docx';
      } 


      if(File::exists($companyFolderPath.'/data.xlsx')){

           $company_sheet = Excel::selectSheets('company')->load($path)->get(); 
           $company_products = Excel::selectSheets('products')->load($path)->get(); 
           $company_press = Excel::selectSheets('pressrealeses')->load($path)->get();   
           $company_whitepapers = Excel::selectSheets('whitepapaers')->load($path)->get();
           $company_catalogs = Excel::selectSheets('catalog')->load($path)->get();
           $company_videos = Excel::selectSheets('videos')->load($path)->get();

     


           if($company_sheet->count()){    
               foreach ($company_sheet as $key => $value) {
                    //logo
                    if(File::exists($companyFolderPath.'/cropped/'.$value->logo.'.jpg')){

                    }else{
                     $this->error = 1;                   
                     $this->not_found_docs[$i]['company'] = $companyName;
                     $this->not_found_docs[$i]['logo'] = $value->logo.'.jpg';
                    } 
                    //End logo 

                    //company name
                    if($value->name == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['name'] = '0';

                    }
                    //End company name

                    //company Email
                    if($value->email == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['email'] = '0';

                    }else{
                        $cm_check = Company::where('email',$value->email)->get();
                        if($cm_check->count() != 0 ){
                            $this->error = 1;                   
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['duplicate'] = '0';
                        }
                         $user_check = User::where('email',$value->email)->get();
                         if($user_check->count() != 0 ){
                            $this->error = 1;                   
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['duplicate'] = '0';
                        }
                    }
                    //End company email

                    //company contact name
                    if($value->contact_name == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['contact_name'] = '0';

                    }
                    //End company contact name

                    //company Country
                    if($value->country == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['country'] = '0';

                    }
                    //End company Country

                    //company website
                    if($value->website == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['website'] = '0';

                    }
                    //End company website

                    //company logo
                    if($value->logo == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['clogo'] = '0';

                    }
                    //End company logo

                    //company address
                    if($value->address == '' ){
                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['address'] = '0';

                    }
                    //End company address

                } 


             }else{

                $this->error = 1;                   
                $this->not_found_docs[$i]['company'] = $companyName;
                $this->not_found_docs[$i]['company_sheet'] = '0';

            }

            if($company_products->count()){      
                 $j= 0;
                 foreach ($company_products as $key => $value) {
                    $cat_check = Category::where('name', trim($value->category_id))->where('parent_id','!=',22)->get();

                      if($value->title != ''){
                       if(File::exists($companyFolderPath.'/cropped/products/'.$value->small_image.'.jpg')){
                           
                       }else{

                            $this->error = 1;                   
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$j]['product'] = $value->title;
                            $this->not_found_docs[$i]['data'][$j]['small_image'] = $value->small_image.'.jpg';                    
                        
                       }
                       if($cat_check->count() == 0 ){
                             $this->error = 1;
                             $this->not_found_docs[$i]['company'] = $companyName;
                              $this->not_found_docs[$i]['data'][$j]['product'] = $value->title;
                            $this->not_found_docs[$i]['data'][$j]['category'] = $value->category_id;
                       }
                       if(File::exists($companyFolderPath.'/cropped/products/'.$value->big_image.'.jpg')){
                       
                       }else{
                            
                            $this->error = 1;
                             $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$j]['product'] = $value->title;
                            $this->not_found_docs[$i]['data'][$j]['big_image'] = $value->big_image.'.jpg';
                       }

                       if ($value->tech_spec_pdf) {
                         
                     
                         if(File::exists($companyFolderPath.'/cropped/products/'.$value->tech_spec_pdf.'.pdf')){
                       
                       }else{
                            
                            $this->error = 1;
                             $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$j]['product'] = $value->title;
                            $this->not_found_docs[$i]['data'][$j]['tech_spec_pdf'] = $value->tech_spec_pdf.'.pdf';
                       }
                         }

                       if(File::exists($companyFolderPath.'/documents/'.trim($value->doc_file).'.docx')){
                            
                       }else{

                            $this->error = 1;
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$j]['product'] = $value->title;
                            $this->not_found_docs[$i]['data'][$j]['document'] = $value->doc_file.'.docx';                    
                       }
                      }
                      $j =$j+1;
                 }
            }

            if($company_press->count()){    
              $j= 0;  
                 foreach ($company_products as $key => $value) {
                      if($value->title != ''){
                       if(File::exists($companyFolderPath.'/cropped/pressrealese/'.$value->image.'.jpg')){

                       }else{

                            $this->error = 1;                   
                            $this->not_found_docs[$i]['company'] = $companyName;                   
                            $this->not_found_docs[$i]['data'][$j]['press_image'] = $value->image.'.jpg';                    
                        
                       }
                       if(File::exists($companyFolderPath.'/cropped/pressrealese/'.$value->pdf.'.pdf')){

                       }else{
                            
                            $this->error = 1;
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$j]['press_pdf'] = $value->pdf.'.pdf';
                       }
                      }
                      $j =$j+1;
                 }
            }

                if($company_catalogs->count()){    
                  $k= 0;  
                  foreach ($company_catalogs as $key => $value) {
                      if($value->title != ''){
                       if(File::exists($companyFolderPath.'/catalogues/'.$value->image.'.jpg')){

                       }else{

                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;                   
                        $this->not_found_docs[$i]['data'][$k]['cat_image'] = $value->image.'.jpg';                    

                    }
                    if(File::exists($companyFolderPath.'/catalogues/'.$value->pdf.'.pdf')){

                    }else{

                        $this->error = 1;
                        $this->not_found_docs[$i]['company'] = $companyName;
                        $this->not_found_docs[$i]['data'][$k]['cat_pdf'] = $value->pdf.'.pdf';
                    }
                }
                $k =$k+1;
                }
            }

            if($company_whitepapers->count()){    
              $l= 0;  
              foreach ($company_whitepapers as $key => $value) {
                    if($value->title != ''){
                         if(File::exists($companyFolderPath.'/cropped/whitepaper/'.$value->image.'.jpg')){

                         }else{

                            $this->error = 1;                   
                            $this->not_found_docs[$i]['company'] = $companyName;                   
                            $this->not_found_docs[$i]['data'][$l]['white_image'] = $value->image.'.jpg';                    
                            
                        }
                        if(File::exists($companyFolderPath.'/cropped/whitepaper/'.$value->pdf.'.pdf')){

                        }else{

                            $this->error = 1;
                            $this->not_found_docs[$i]['company'] = $companyName;
                            $this->not_found_docs[$i]['data'][$l]['white_pdf'] = $value->pdf.'.pdf';
                        }
                    }
                $l =$l+1;
                }
            }


            if($company_videos->count()){    
              $m= 0;  
              foreach ($company_videos as $key => $value) {
                  if($value->title != ''){
                     if(File::exists($companyFolderPath.'/video/'.$value->video.'.mp4')){

                     }else{

                        $this->error = 1;                   
                        $this->not_found_docs[$i]['company'] = $companyName;      
                        $this->not_found_docs[$i]['data'][$m]['video_name'] = $value->title;             
                        $this->not_found_docs[$i]['data'][$m]['video'] = $value->video.'.mp4';                    
                        
                    }
                  
                    }
                $m =$m+1;
                }
            }


    }
      else{
       $this->error = 1;                   
       $this->not_found_docs[$i]['company'] = $companyName;
       $this->not_found_docs[$i]['xlxs_sheet'] = 'data.xlsx';
      } 


     if($this->error  == 1){

         $this->i = $this->i + 1;
    }

    return true;
}
// End validations method

}
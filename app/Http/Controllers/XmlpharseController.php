<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use xml;
use News;
use App\Xmlpharse;
use Orchestra\Parser\Xml\Facade as XmlParser;
use File;
use DB;
use App\URL;

class XmlpharseController extends Controller
{
   public function prnewsreport()
  {


    $prnews = DB::table('news_xml')->where('type','prnews')->get();

    return view('pharse.index',compact('prnews'));
  



  }
   public function businesreport()
  {


    $businesnews = DB::table('news_xml')->where('type','bussinesswire')->get();

    return view('pharse.businesnews',compact('businesnews'));
  



  }

   public function globalreport()
  {


    $globalnews = DB::table('news_xml')->where('type','globalnews')->get();

    return view('pharse.globalnews',compact('globalnews'));
  



  }
   //prnews xml pharsing

	public function prnews(Request $request)
	{

    
  // set up basic connection
   $conn_id = ftp_connect('supplier-buyer.com');

  // login with username and password
   $login_result = ftp_login($conn_id,'pnplant@supplier-buyer.com','Em{?IGK?N{(m');

   // get contents of the current directory
  
  
   $buff = ftp_rawlist($conn_id, '/');

    $contents = ftp_nlist($conn_id, ".");

   $path =base_path().'/../mediaroom/';

   $totalfiles=count($contents);

if($totalfiles>3){




   for($i=3;$i<=($totalfiles-1);$i++){

    

 //$data="http://www.supplier-buyer.com/plantautomation/prnewswire/".$contents[$i];

                    $local_file =$path."prnews_temp.xml";

                    $path_parts = pathinfo($contents[$i]);

                      $ext = @$path_parts['extension'];


                    if($ext=="xml"){


                    $handle = fopen($local_file, 'w');

                    $remote_file = @$contents[$i];

               
                    @ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0);

                    $data = file_get_contents($local_file);
               
                    $data = str_replace(array("\r", "\n"), '', $data);

                    $myfile = fopen($local_file, "w");

                    fwrite($myfile, $data);
              

/* Method 1 */
                 
                   $key=$totalfiles;

                  // if ($key > 1) {

                   

                          $xmlDoc = new \DOMDocument();

                          $data=@$xmlDoc->load("$local_file");
       
                          $x = $xmlDoc->documentElement;

                          $lastdate=$xmlDoc->getElementsByTagName('NewsIdentifier')->item(0)->getElementsByTagName('DateId')->item(0)->nodeValue;

                          $xnlocation=strip_tags($this->htmlphasre($xmlDoc, "xn-location", "class"));
                          $newsid=$xmlDoc->getElementsByTagName('NewsLines')->item(0)->getElementsByTagName('HeadLine')->item(0)->nodeValue;



              
                $news_head = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('h1')->item(0)->nodeValue);
                $issuer = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('p')->item(0)->nodeValue);
                 $story_date = date("Y-m-d H:i:s", strtotime($lastdate));

            
                //$this->news_model->data_full = file_get_contents("$file_dir$value");
                $Data = addslashes($this->xmlphasre($x->getElementsByTagName('div')->item(1)));
                $location = $xnlocation;
               $xml_file_name = addslashes($contents[$i]);

                \Log::info('file name:' .$xml_file_name);
                $desc= $this->xmlphasre($x->getElementsByTagName('div')->item(1));
                $sub = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('h1')->item(0)->nodeValue);


                  $mtitle_filter =preg_replace("/[^ \w]+/", "", $sub);
                  $mtitle=substr($mtitle_filter,0,20);
                  $mdesc = substr($mtitle_filter,0,35);

                  $short_data=substr($desc,0,500);

               $data=array('news_head'=>$news_head,'data'=>$desc,'location'=>$location,'type'=>'prnews','xml_file_name'=>$xml_file_name,'meta_title'=>$mtitle,'meta_description'=>$mdesc,'story_date'=>$story_date,'active_flag'=>'1','news_url'=>str_slug($news_head));

               $xmlpharser=new Xmlpharse($data);

               $xmlpharser->create($data);

               if($xml_file_name){

                         $oldpath=$xml_file_name;
                     
                         $newpath="/Backup-XML/".$xml_file_name;
                        
                         ftp_rename($conn_id, $oldpath, $newpath);
                                       
                     }
                        

        }



   // }
     else{

echo "File type not a XML";



}
      
}

}
else{
echo "No Files found";

}


	}

	// End prnews pharsing

	// BUSINESS WIRE pharsing
public function businesswire()
{

 
  // set up basic connection
   $conn_id = ftp_connect('supplier-buyer.com');

  // login with username and password
   $login_result = ftp_login($conn_id,'bwplant@supplier-buyer.com','Em{?IGK?N{(m');

   // get contents of the current directory
  
  
   $buff = ftp_rawlist($conn_id, '/');

   $contents = ftp_nlist($conn_id, ".");

  // print_r($contents);

   $totalfiles=count($contents);
   $path =base_path().'/../mediaroom/';


   for($i=2;$i<=($totalfiles-1);$i++){

 //$data="http://www.supplier-buyer.com/plantautomation/businesswire/".$contents[$i];
                       $local_file =$path."businesswire_temp.html";
                       $path_parts = pathinfo($local_file);
                       $ext = $path_parts['extension'];


                    if($path_parts['extension']=="html"){

    return "Hi Hello";

    

                 $handle = fopen($local_file, 'w');

                 $remote_file = $contents[$i];

                 ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0);

                   $data = file_get_contents($local_file);

                  $data = str_replace(array("\r", "\n"), '', $data);

                  $myfile = fopen($local_file, "w");
                  fwrite($myfile, $data);
/* Method 1 */
                 
                   $key=$totalfiles;

                   if ($key > 1) {

                        

                $htmlDoc = new \DOMDocument();
                $htmlDoc->load($local_file);

                $x = $htmlDoc->documentElement;

                 $subject = addslashes($x->getElementsByTagName('h1')->item(0)->nodeValue);
              
                $issuer = "Bussinesswire";
               
             
                $pr_dt = date("Y-m-d H:i:s", strtotime(str_replace('UTC', '', strip_tags($this->htmlphasre($htmlDoc, "bwStoryDateline", "class")))));
               
              
                $description = preg_replace("/<\/?div[^>]*\>/i", "", $this->htmlphasre($htmlDoc, "bwStoryBody", "id"));

                $htmlfilename = $contents[$i];
                 
             
                $sub = addslashes($x->getElementsByTagName('h1')->item(0)->nodeValue);
                
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $this->htmlphasre($htmlDoc, "bwStoryBody", "id"));
               
               
                 $mtitle= preg_replace("/[^ \w]+/", "",$sub);
               
                 $mdesc = substr($des,0,35);
                $short_data=substr($description,0,500);
              
                $htmlfilename = addslashes($contents[$i]);

                 $data=array('news_head'=>$subject,'data'=>$description,'type'=>'bussinesswire','xml_file_name'=>$htmlfilename,'meta_title'=>$mtitle,'meta_description'=>$mdesc,'story_date'=>$pr_dt,'active_flag'=>'1','news_url'=>str_slug($subject));

                  $xmlpharser=new Xmlpharse($data);
   
                  $xmlpharser->create($data);
                
                    if($htmlfilename){

                         $oldpath=$htmlfilename;
                     
                         $newpath="/Backup-XML/".$htmlfilename;
                        
                         ftp_rename($conn_id, $oldpath, $newpath);
                                       
                     }
                        else{

                       }
               


                
                
                }
            }
       }

}




// End BUSINESS WIRE pharsing

 //Globalnews xml pharsing

  public function globalnews(Request $request)
  {


   // set up basic connection
   $conn_id = ftp_connect('supplier-buyer.com');

  // login with username and password
   $login_result = ftp_login($conn_id,'gdataplant@supplier-buyer.com','Em{?IGK?N{(m');

   // get contents of the current directory
  
  
   $buff = ftp_rawlist($conn_id, '/');

   $contents = ftp_nlist($conn_id, ".");



   $totalfiles=count($contents);
   $path =base_path().'/../mediaroom/';

    

   for($i=2;$i<=($totalfiles-1);$i++){

   //$data="http://www.supplier-buyer.com/plantautomation/globalnews/".$contents[$i];
      $local_file =$path."globalwire_temp.xml";
     $path_parts = pathinfo($contents[$i]);
     $ext = @$path_parts['extension'];
     if(@$path_parts['extension']=="xml"){

                 $handle = fopen($local_file, 'w');

                 $remote_file = $contents[$i];

                 ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0);

                  $data = file_get_contents($local_file);

                  $data = str_replace(array("\r", "\n"), '', $data);

                $myfile = fopen($local_file, "w");
                fwrite($myfile, $data);

/* Method 1 */
                 
                   $key=$totalfiles;

                   if ($key > 1) {

                 $path_parts = pathinfo($local_file);

                 $ext = $path_parts['extension'];

                
                 if($path_parts['extension']=="xml"){
                   

                $xmlDoc = new \DOMDocument();

                $data=$xmlDoc->load($local_file);
            
                $x = $xmlDoc->documentElement;

                $news_head = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('hl1')->item(0)->nodeValue);
                 
                $issuer = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('distributor')->item(0)->nodeValue);

                $story_date = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('dateline')->item(0)->nodeValue));
               
                $Data = addslashes($this->xmlphasre($x->getElementsByTagName('body.content')->item(0)));
                $xml_file_name = addslashes($contents[$i]);
                $sub = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('hl1')->item(0)->nodeValue);
                $desc = preg_replace("/<\/?div[^>]*\>/i", "", $this->xmlphasre($x->getElementsByTagName('body.content')->item(0)));

               /* $mtitle =substr($sub,0,35);*/
                $mtitle= preg_replace("/[^ \w]+/", "",$sub);
                $mdesc = substr($desc,0,35);
                 $short_data=substr($desc,0,500);
               $data=array('news_head'=>$news_head,'data'=>$desc,'type'=>'globalnews','xml_file_name'=>$xml_file_name,'meta_title'=>$mtitle,'meta_description'=>$mdesc,'story_date'=>$story_date,'active_flag'=>'1','news_url'=>str_slug($news_head));

               $xmlpharser=new Xmlpharse($data);

               $xmlpharser->create($data);

                if($xml_file_name){

                         $oldpath=$xml_file_name;
                     
                         $newpath="/Backup-XML/".$xml_file_name;
                        
                         ftp_rename($conn_id, $oldpath, $newpath);
                                       
                     }
                        else{

                       }
         
            }
        }
    }

    else{

      echo"No files found";
    }


  }

}

  // End Global pharsing

  //Indbwwires 
   public function indbwwires() {
    
        
       // set up basic connection
   $conn_id = ftp_connect('supplier-buyer.com');

  // login with username and password
   $login_result = ftp_login($conn_id,'bwiplant@supplier-buyer.com','IcF*jtM)IkyX');

   // get contents of the current directory
  
  
   $buff = ftp_rawlist($conn_id, '/');

   $contents = ftp_nlist($conn_id, ".");



   $totalfiles=count($contents);

   $path =base_path().'/../mediaroom/';

   for($i=2;$i<=($totalfiles-1);$i++){

   //$data="http://www.supplier-buyer.com/pulpandpaperautomation/indbwwires/".$contents[$i];
/* Method 1 */
 //$local_file =$_SERVER['DOCUMENT_ROOT']."/mediaroom/businesswireind_temp.xml";
  $local_file =$path."bussineswind_temp.xml";
                    $remote_file = $contents[$i];

                    $path_parts = pathinfo($remote_file);
                    $ext = $path_parts['extension'];
                    if($ext=="xml"){


                  $handle = fopen($local_file, 'w');

                  $remote_file = $contents[$i];

                  ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0);

                  $data = file_get_contents($local_file);

                  $data = str_replace(array("\r", "\n"), '', $data);

                  $myfile = fopen($local_file, "w");
                  fwrite($myfile, $data);
                 
                   $key=$totalfiles;

                   if ($key > 1) {

                 

            //if($ext !="" && $ext !="ftpquota" && file_get_contents($data)!=''){
                $xmlDoc = new \DOMDocument();
                $xmlDoc->load($local_file);
                $x = $xmlDoc->documentElement;

                
                $sub = addslashes($x->getElementsByTagName('title')->item(0)->nodeValue);
               // $subject = addslashes($x->getElementsByTagName('title')->item(0)->nodeValue);
                $issuertype = "indwire";

                $news_head=addslashes($x->getElementsByTagName('title')->item(0)->nodeValue);
              //  $pr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('postdate')->item(0)->nodeValue));
                $pr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('pubDate')->item(0)->nodeValue));
               

                $desc = preg_replace("/<\/?div[^>]*\>/i", "", $this->xmlphasre($x->getElementsByTagName('description')->item(0)));
               
                $htmlfilename = addslashes($contents[$i]);
             
$mtitleinfo=preg_replace('/[^A-Za-z0-9\-]/', '',$sub);
                 $mtitle =substr($mtitleinfo,0,35);
                 $mdesc = substr($desc,0,35);

                  $data=array('news_head'=> $news_head,'data'=>$desc,'type'=>$issuertype,'xml_file_name'=>$htmlfilename,'meta_title'=>$mtitle,'meta_description'=>$mdesc,'story_date'=>$pr_dt,'active_flag'=>'1','news_url'=>str_slug($news_head));

               $xmlpharser=new Xmlpharse($data);

               $xmlpharser->create($data);

                

                       if($htmlfilename){

                         $oldpath=$htmlfilename;
                     
                         $newpath="/Backup-XML/".$htmlfilename;
                        
                         ftp_rename($conn_id, $oldpath, $newpath);
                                       
                     }
                       
}
            }
        }

     }

  //End Indbwwires


	private function xmlphasre($sxe) {


        if ($sxe === false) {
            echo 'Error while parsing the document';
            exit;
        }

        $dom_sxe = dom_import_simplexml($sxe);
        if (!$dom_sxe) {
            echo 'Error while converting XML';
            exit;
        }

        $dom = new \DOMDocument();
        $dom_sxe = $dom->importNode($dom_sxe, true);
        $dom_sxe = $dom->appendChild($dom_sxe);
        return $data = $dom->saveHTML();
    }
    private function htmlphasre($Doc, $attributename, $attributetype) {
        $finder = new \DomXPath($Doc);

        $tmp_dom = new \DOMDocument();
        $nodes = $finder->query("//*[contains(@$attributetype, '$attributename')]");
        foreach ($nodes as $node) {
            $tmp_dom->appendChild($tmp_dom->importNode($node, true));
        }
        return $tmp_dom->saveHTML();
    }
}

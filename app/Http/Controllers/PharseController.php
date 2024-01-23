<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Pressrelease;
use Illuminate\Http\Request;
use \Session;
ini_set('max_execution_time', 600);

class PharseController extends Controller
{
    protected $model;

    public function __construct(Pressrelease $model)
    {
        $this->model = $model;
    }

    public function prnews() {
        $this->load->model('news_model');
        $xml_dir = $_SERVER['DOCUMENT_ROOT']."/mediaroom/prnews/";
        $scan_dir = scandir($xml_dir);
        foreach ($scan_dir as $key => $value) {
        
            if ($key > 1) {
            
            $path_parts = pathinfo( $xml_dir.$value);
            //print_r($path_parts);
            if($path_parts['extension']=="xml" &&  file_get_contents($xml_dir.$value)!=''){

                $xmlDoc = new DOMDocument();
                $xmlDoc->load("$xml_dir$value");
                $lastdate=$xmlDoc->getElementsByTagName('NewsIdentifier')->item(0)->getElementsByTagName('DateId')->item(0)->nodeValue;
                $xnlocation=strip_tags($this->htmlphasre($xmlDoc, "xn-location", "class"));
                $x = $xmlDoc->documentElement;
                $this->news_model->news_head = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('h1')->item(0)->nodeValue);
                $this->news_model->issuer = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('p')->item(0)->nodeValue);
                $this->news_model->story_date = date("Y-m-d H:i:s", strtotime($lastdate));
                //$this->news_model->data_full = file_get_contents("$xml_dir$value");
                $this->news_model->Data = addslashes($this->xmlphasre($x->getElementsByTagName('div')->item(1)));
                $this->news_model->location = $xnlocation;
                $this->news_model->xml_file_name = addslashes($value);
              
                $lastid = $this->news_model -> insert_entry();
                $sub = addslashes($x->getElementsByTagName('div')->item(0)->getElementsByTagName('h1')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $this->xmlphasre($x->getElementsByTagName('div')->item(1)));
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "prnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
            $this -> metatags_model -> add_records_dynamic($metadetails);
                
                
                
                
                $backup =$_SERVER['DOCUMENT_ROOT']."/mediaroom/prnews/Backup-XML/";
                if (copy($xml_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($xml_dir. $value);
                }else{
                //echo "ERRoR";
                }
                
             }else{


}            
             
            }
            
        
        }
        exit;
       // $this->layout->view('press/edit');
    }

    public function globalnews() {
    
    
        $this->load->model('news_model');
        $xml_dir = $_SERVER['DOCUMENT_ROOT']."/mediaroom/globalnews/";
        $scan_dir = scandir($xml_dir);

        foreach ($scan_dir as $key => $value) {
            if ($key > 1) {
            $path_parts = pathinfo( $xml_dir.$value);
            if($path_parts['extension']=="xml" &&  file_get_contents($xml_dir.$value)!=''){

                $xmlDoc = new DOMDocument();
                $xmlDoc->load($xml_dir . "$value");

                $x = $xmlDoc->documentElement;

                $this->news_model->news_head = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('hl1')->item(0)->nodeValue);
                $this->news_model->issuer = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('distributor')->item(0)->nodeValue);

                $this->news_model->story_date = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('dateline')->item(0)->nodeValue));
                //$this->news_model->data_full = file_get_contents($xml_dir . "$value");
                $this->news_model->Data = addslashes($this->xmlphasre($x->getElementsByTagName('body.content')->item(0)));
                $this->news_model->xml_file_name = addslashes($value);
//        // echo dom_import_simplexml($xml->body->{'body.content'})->textContent;
//        echo $data;

               
                
                $lastid =   $this->news_model->insert_entry();
                $sub = addslashes($x->getElementsByTagName('body.head')->item(0)->getElementsByTagName('hl1')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $this->xmlphasre($x->getElementsByTagName('body.content')->item(0)));
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "gwnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
            $this -> metatags_model -> add_records_dynamic($metadetails);
                
                
                $backup = $_SERVER['DOCUMENT_ROOT']."/mediaroom/globalnews/Backup-XML/";
                if (copy($xml_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($xml_dir. $value);
                }
                
                }
            }
        }
        exit;
        $this->layout->view('press/edit');
    }

    public function bussinesswire() {
        $this->load->model('press_model');
       
        $html_dir = $_SERVER['DOCUMENT_ROOT']."/mediaroom/bussinesswire/";
        $scan_dir = scandir($html_dir);

        foreach ($scan_dir as $key => $value) {
            if ($key > 1) {
            $path_parts = pathinfo( $html_dir.$value);
            if($path_parts['extension']=="html" &&  file_get_contents($html_dir.$value)!=''){

                $htmlDoc = new DOMDocument();
                $htmlDoc->load($html_dir . "$value");
                $x = $htmlDoc->documentElement;

                $this->press_model->subject = addslashes($x->getElementsByTagName('h1')->item(0)->nodeValue);
                $this->press_model->issuer = "Bussinesswire";
              //  $this->press_model->data_full = file_get_contents($html_dir . "$value");
                $this->press_model->pr_dt = date("Y-m-d H:i:s", strtotime(str_replace('UTC', '', strip_tags($this->htmlphasre($htmlDoc, "bwStoryDateline", "class")))));
                //$this->press_model->description = addslashes($this->htmlphasre($htmlDoc, "bwStoryBody", "id"));
                $this->press_model->description = preg_replace("/<\/?div[^>]*\>/i", "", $this->htmlphasre($htmlDoc, "bwStoryBody", "id"));

                $this->press_model->htmlfilename = addslashes($value);
               
                
                
                $lastid =  $this->press_model->insert_entry();
                $sub = addslashes($x->getElementsByTagName('h1')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $this->htmlphasre($htmlDoc, "bwStoryBody", "id"));
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "bwnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
            $this -> metatags_model -> add_records_dynamic($metadetails);
                
                
                
                $backup =$_SERVER['DOCUMENT_ROOT']."/mediaroom/bussinesswire/Backup-XML/";
                if (copy($html_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($html_dir. $value);
                }
                
                }
            }
        }

        exit;
        $this->layout->view('press/edit');
    }

    public function indbwwires() {
        $this->load->model('press_model');
        $xml_dir =  $_SERVER['DOCUMENT_ROOT']."/mediaroom/indbwwires/";
        $scan_dir = scandir($xml_dir);
        foreach ($scan_dir as $key => $value) {
            if ($key > 1) {
            $path_parts = pathinfo( $xml_dir.$value);
            if($path_parts['extension']=="xml" &&  file_get_contents($xml_dir.$value)!=''){
                $xmlDoc = new DOMDocument();
                $xmlDoc->load($xml_dir . "$value");
                $x = $xmlDoc->documentElement;

                $this->press_model->subject = addslashes($x->getElementsByTagName('headline')->item(0)->nodeValue);
                $this->press_model->subject = addslashes($x->getElementsByTagName('title')->item(0)->nodeValue);
                $this->press_model->issuertype = "Bussinesswireind";
                $this->press_model->pr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('postdate')->item(0)->nodeValue));
                $this->press_model->pr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('pubDate')->item(0)->nodeValue));
                $this->press_model->subcats = addslashes($x->getElementsByTagName('subcats')->item(0)->nodeValue);
                $this->press_model->subcats = addslashes($x->getElementsByTagName('subtitle')->item(0)->nodeValue);
                $this->press_model->keyword = addslashes($x->getElementsByTagName('keyword')->item(0)->nodeValue);
                $this->press_model->source = addslashes($x->getElementsByTagName('source')->item(0)->nodeValue);
                $this->press_model->category = addslashes($x->getElementsByTagName('category')->item(0)->nodeValue);
                $this->press_model->location = addslashes($x->getElementsByTagName('location')->item(0)->nodeValue);
                $this->press_model->location = addslashes($x->getElementsByTagName('releasetype')->item(0)->nodeValue);
                $this->press_model->abstract = addslashes($x->getElementsByTagName('abstract')->item(0)->nodeValue);
                $this->press_model->abstract = addslashes($x->getElementsByTagName('summary')->item(0)->nodeValue);
                $this->press_model->description = $x->getElementsByTagName('CONTENT')->item(0)->nodeValue;
                $this->press_model->description = $x->getElementsByTagName('description')->item(0)->nodeValue;
                $this->press_model->contact = $x->getElementsByTagName('contact')->item(0)->nodeValue;
                $this->press_model->email = $x->getElementsByTagName('email')->item(0)->nodeValue;
                $this->press_model->contact = $x->getElementsByTagName('contact1')->item(0)->nodeValue;
                $this->press_model->email = $x->getElementsByTagName('email1')->item(0)->nodeValue;
                $this->press_model->companylogo = $x->getElementsByTagName('companylogo')->item(0)->nodeValue;
                $this->press_model->htmlfilename = $value;
                $this->press_model->press_releases_url = trim( preg_replace( array( '`[^a-z0-9]`i','`[-]+`'), '-', strtolower($x->getElementsByTagName('headline')->item(0)->nodeValue) ), '-' );


               
                
                $lastid =   $this->press_model->insert_entry();
                $sub = addslashes($x->getElementsByTagName('headline')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $x->getElementsByTagName('description')->item(0)->nodeValue);
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "bwnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
            $this -> metatags_model -> add_records_dynamic($metadetails);
                
               
                $backup =$_SERVER['DOCUMENT_ROOT']."/mediaroom/indbwwires/Backup-XML/";
                if (copy($xml_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($xml_dir. $value);
                }
                }
            }
        }
        exit;
    }
    
    public function gdreports() {
        $this->load->model('reports_model');
        $xml_dir =  $_SERVER['DOCUMENT_ROOT']."/mediaroom/gdreports/";
        $scan_dir = scandir($xml_dir);

        foreach ($scan_dir as $key => $value) {
            if ($key > 1) {
            $path_parts = pathinfo( $xml_dir.$value);
            if($path_parts['extension']=="xml" &&  file_get_contents($xml_dir.$value)!=''){
                $xmlDoc = new DOMDocument();
                $xmlDoc->load($xml_dir . "$value");

                $x = $xmlDoc->documentElement;
                $this->reports_model->Title = addslashes($x->getElementsByTagName('Title')->item(0)->nodeValue);
                $this->reports_model->issuer = "GD Reoports";
                $this->reports_model->gr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('PublicationDate')->item(0)->nodeValue));
              //  $this->reports_model->data_full = file_get_contents($xml_dir . "$value");
                $this->reports_model->Data = $x->getElementsByTagName('Summary')->item(0)->nodeValue;
                $this->reports_model->xml_file_name = $value;
              
                
                $lastid = $this->reports_model->insert_entry();
                $sub = addslashes($x->getElementsByTagName('Title')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $x->getElementsByTagName('Summary')->item(0)->nodeValue);
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "bwnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
                 $this -> metatags_model -> add_records_dynamic($metadetails);
          
                
                $backup =$_SERVER['DOCUMENT_ROOT']."/mediaroom/gdreports/Backup-XML/";
                if (copy($xml_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($xml_dir. $value);
                }
                
                }
            }
        }
        exit;
    }

    public function mpreports() {
        $this->load->model('reports_model');
        $xml_dir =  $_SERVER['DOCUMENT_ROOT']."/mediaroom/mpreports/";
        $scan_dir = scandir($xml_dir);

        foreach ($scan_dir as $key => $value) {
            if ($key > 1) {
            $path_parts = pathinfo( $xml_dir.$value);
            if($path_parts['extension']=="xml" &&  file_get_contents($xml_dir.$value)!=''){
                $xmlDoc = new DOMDocument();
                $xmlDoc->load($xml_dir . "$value");
                $x = $xmlDoc->documentElement;
                $this->reports_model->Title = addslashes($x->getElementsByTagName('Title')->item(0)->nodeValue);
                $this->reports_model->issuer = "GD Reoports";
                $this->reports_model->gr_dt = date("Y-m-d H:i:s", strtotime($x->getElementsByTagName('PublicationDate')->item(0)->nodeValue));
                //$this->reports_model->data_full = file_get_contents($xml_dir . "$value");
                $this->reports_model->Data = addslashes($x->getElementsByTagName('Summary')->item(0)->nodeValue);
                $this->reports_model->xml_file_name = $value;
                $this->reports_model->insert_entry();
                
                
                $lastid = $this->reports_model->insert_entry();
                $sub = addslashes($x->getElementsByTagName('Title')->item(0)->nodeValue);
                $des = preg_replace("/<\/?div[^>]*\>/i", "", $x->getElementsByTagName('Summary')->item(0)->nodeValue);
                 $this->load->model('metatags_model');
                 $mtitle = word_limiter(strip_tags(html_entity_decode(ucfirst($sub))), 9);
                 $mdesc = word_limiter(strip_tags(html_entity_decode(ucfirst($des))), 22);
                 $metadetails = array(
                'company_id' => $lastid, 
                'page' => "bwnews", 
                'type' => "pressreleases", 
                'meta_title' => $mtitle, 
                'meta_description' => $mdesc, 
                'status' => 'Active', 
                'created_date' => date('Y-m-d H:i:s'));
                 $this -> metatags_model -> add_records_dynamic($metadetails);
                 
                
                $backup =$_SERVER['DOCUMENT_ROOT']."/mediaroom/mpreports/Backup-XML/";
                if (copy($xml_dir . $value, $backup . $value)) {
                    chmod($backup.$value, '755');
                    unlink($xml_dir. $value);
                }
                
                }
            }
        }

        exit;
    }

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

        $dom = new DOMDocument();
        $dom_sxe = $dom->importNode($dom_sxe, true);
        $dom_sxe = $dom->appendChild($dom_sxe);
        return $data = $dom->saveHTML();
    }

    private function htmlphasre($Doc, $attributename, $attributetype) {
        $finder = new DomXPath($Doc);

        $tmp_dom = new DOMDocument();
        $nodes = $finder->query("//*[contains(@$attributetype, '$attributename')]");
        foreach ($nodes as $node) {
            $tmp_dom->appendChild($tmp_dom->importNode($node, true));
        }
        return $tmp_dom->saveHTML();
    }

}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

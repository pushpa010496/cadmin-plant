<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use \Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Slider;
use App\Banner;

class BannerNotifyController extends Controller
{
  
   public function index(){  

     //Banner expiring
      $time = \Carbon\Carbon::now()->modify('+1 days')->format('Y-m-d');
      $expire_soon =  Banner::where('active_flag','=', 1)->whereDate('to_date', '=' , $time)->where('from_date', '<=' , $time)->get();
      $expire_today =  Banner::where('active_flag','=', 1)->whereDate('to_date', '=' , date('Y-m-d'))->where('from_date', '<=' , $time)->get();

      if(count($expire_soon) or count($expire_today)){
           $data = [                     
            'data1'=> $expire_soon,
            'data2'=>$expire_today
          ];

          Mail::send('emails.banner_expire', $data, function($message) use ($data) {
            // $message->to('nagaraj@ochre-media.com');
            $message->to('samsmith@ochre-media.com');
            $message->cc('itsupport@ochre-media.com');
            $message->subject('Banners Update - Plantautomationt');

          });
      }

        return 'Success';
    }

     public function slider(){  

     //Slider expiring
      $time = \Carbon\Carbon::now()->modify('+1 days')->format('Y-m-d');
      $expire_soon =  Slider::where('active_flag','=', 1)->whereDate('to_date', '=' , $time)->where('from_date', '<=' , $time)->get();
      $expire_today =  Slider::where('active_flag','=', 1)->whereDate('to_date', '=' , date('Y-m-d'))->where('from_date', '<=' , $time)->get();

      if(count($expire_soon) or count($expire_today)){
           $data = [                     
            'data1'=> $expire_soon,
            'data2'=>$expire_today
          ];

          Mail::send('emails.banner_expire', $data, function($message) use ($data) {
            // $message->to('nagaraj@ochre-media.com');
            // $message->to('naveen@ochre-media.com');
            $message->to('samsmith@ochre-media.com');
            $message->cc(['itsupport@ochre-media.com','omplenquiry@ochre-media.com']);
            $message->subject('Slider Update - Plantautomationt');

          });
      }

        return 'Success';
    }
    
     public function profile(){  

     //Slider expiring
       $time = \Carbon\Carbon::now()->modify('+30 days')->format('Y-m-d');
   $expire_soon =  Company::where('active_flag','=', 1)->whereDate('end_date', '=' , $time)->where('start_date', '<=' , $time)->get();
      $expire_today =  Company::where('active_flag','=', 1)->whereDate('end_date', '=' , date('Y-m-d'))->where('start_date', '<=' , $time)->get();

      if(count($expire_soon) or count($expire_today)){
           $data = [                     
            'data1'=> $expire_soon,
            'data2'=>$expire_today
          ];

          Mail::send('emails.profile_expire', $data, function($message) use ($data) {
            // $message->to('nagaraj@ochre-media.com');
            $message->to('samsmith@ochre-media.com');
            $message->cc(['itsupport@ochre-media.com','omplenquiry@ochre-media.com']);
            $message->subject('profile Update - Plantautomationt');

          });
      }

        return 'Success';
    }
}

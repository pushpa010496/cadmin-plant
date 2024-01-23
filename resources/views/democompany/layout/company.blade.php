<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{ config('app.url') }}img/favicon.ico" type="image/x-icon">


  <!-- Bootstrap CSS -->
  <link href="{{ config('app.url') }}css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ config('app.url') }}css/latest-styles.css">
  {{-- <link rel="stylesheet" href="{{ config('app.url') }}css/font-awesome.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet"> 
  @yield('style')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="{{ config('app.url')}}css/jquery.ui.autocomplete.css">

  <style type="text/css">
    #profile .form-control{border-radius: 0px;} 
    #profile .navbar-expand-lg{ background-color: #92278f;}
    #profile .navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link{ color: rgba(255,255,255,1) }
    #profile .navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover{color: rgba(255,255,255,0.8)
    }
    #profile .btn-radius{border-radius: 20px;background-color: #fff; color:#92278f;border: 1px solid #fff;font-weight: bold; }
    #profile .btn-radius:hover{background-color: #fff; color:#fff;border: 1px solid #fff;}
    #profile .btn-outline-info {
      color: #92278f;
      background-color: transparent;
      background-image: none;
      border-color: #92278f;
    }

    #profile .nav-item.active:after, #profile .navbar-nav li:hover:after {
     width:65%; 
     background: #fff; 
   }
   #profile .navbar-dark .navbar-nav .nav-link.disabled {
    color: rgba(255,255,255,.7);
    cursor: not-allowed;
  }
  #profile .navbar-dark .navbar-nav .active {
    color: #fff !important;
    font-size: 15px;
    font-weight: bold;
  }
  .address-p p{margin-bottom: 3px;line-height: 18px; font-size: 13px;}

  .btn-bot-rad{border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; }
  .btn-top-rad{border-top-left-radius: 25px; border-top-right-radius: 25px; }

   /* Header SEARCH
   ---------------- */
 #main-search > .form-control-sm, .input-group-sm > .form-control, .input-group-sm{font-size: 12px;line-height: 14px;width: 330px;/*border-top-left-radius: 20px;border-bottom-left-radius: 20px; */}
#main-search > .input-group-addon, .input-group-sm > .input-group-btn > .btn{padding: .3rem 10px .3rem 10px;line-height: 1.5;background-color:#92278f;cursor: pointer; border: 1px solid #92278f !important;/*border-top-right-radius: 20px;border-bottom-right-radius: 20px;*/}
#main-search > .input-group-addon, .input-group-sm > .input-group-btn > .btn:hover{background-color:#fff;color:#92278f; }
#main-search .form-control{border: 1px solid #92278f !important;font-size: 14px;}
.Btn-Rad-BR{border-bottom-right-radius:25px;}
#stickyPostRequirement{
  transition: 1s;
}
.btn:hover{background-color: #92278F !important;cursor: pointer; color: #fff;}
@media (max-width: 1099px) {
  .top-bar .sticky-top{position: relative;}
  #company-profile .sticky-top{position: relative;}
  .fixed-top { position: inherit; }
  .navbar{ box-shadow: 0px 4px 6px rgba(0,0,0,.2);}
  #searchForm{position: static !important;}
  .navbar{padding: 0rem 1rem .5rem 1rem}
  .sticky-top{position: static !important;}
  #searchForm > .input-group-sm{width: 240px !important; margin-left: 0px !important}
  #searchForm > .input-group-sm > .form-control{width: 200px !important}
  .navbar-nav li:hover:after {width:70%; background: transparent;}
  .bg-topbar{background-color:#f8f9fa !important;}
}

@media (max-width: 575px) {
  .bg-topbar {
    background-color: #5d085a !important;
  }
}

button.close{
  position: absolute;
  right: 5px;
}
.modal{background-color: rgba(0,0,0,0.4) !important;}
#searchForm{
       /* position: fixed;
       z-index: 99999;*/
     }
     .bg-purple{background-color: #5d085a;}
     .bg-purple2{background-color: #7a0e77;}
     .Btn-Rad-TL{border-bottom-left-radius: 25px;}
   </style>

   <!-- Global site tag (gtag.js) - Google Analytics(as  per bosco) -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91626815-1"></script>
   <script async>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-91626815-1', 'auto');
    ga('send', 'pageview');

  </script>



  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-91626815-1');
  </script>



  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KKG856Z');</script>
<!-- End Google Tag Manager -->


</head>

<body>  
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KKG856Z"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="container-fluid">
      <div class="row fixed-top text-right bg-topbar" >
        <div class="col-12 col-sm-5 col-md-3 pl-0 pr-0 col-lg-2 offset-lg-7 offset-md-5 text-center" id="stickyPostRequirement">
          <a data-toggle="modal" data-target="#postRequirement" class="btn btn-sm btn-secondary btn-bot-rad pl-4 pr-4 text-white font-14" data-toggle="tooltip" title="Not a member yet, no problem!">Post Your Requirement</a>
        </div>

        <div class="col-12 col-sm-7 col-md-4 col-lg-3 bg-purple text-center Btn-Rad-TL" id="rad_top_btn">
          <a href="{{url('/get-listed')}}" class="btn btn-sm bg-purple text-white border-0 mr-3 font-14">Get Listed</a>
          <a href="{{url('/events')}}" class="btn btn-sm bg-purple text-white border-0 font-14">Industrial Events</a>
        </div>
      </div>
    </div>

    <header class="">
      <nav class="navbar navbar-expand-lg navbar-light bg-light div-shadow">
      <!-- <div class="fixed-top offset-lg-6 col-lg-3 col-sm-12 text-center" id="stickyPostRequirement">
          <a data-toggle="modal" data-target="#postRequirement" class="btn btn-sm btn-secondary btn-bot-rad pl-4 pr-4 text-white">Post Your Requirement</a><br>
          <small class="text-muted font-10">Not a member yet, no problem!</small>
      </div>
      <div class="ml-auto top-bar fixed-top col-lg-3 col-sm-12">        
        <div class="btn-group" style="width: 100%;">
          <a href="{{url('/get-listed')}}" class="btn">Get Listed 2</a>
          <a href="{{url('/events')}}" class="btn top-button2" style="width: 100%;
          ">Industrial Events</a>
        </div>
      </div> -->

      {{--   <div class="row fixed-top text-right" >
        <div class="col-md-3 pl-0 pr-0 col-lg-2 offset-lg-7 offset-md-4 text-center" id="stickyPostRequirement">
          <a data-toggle="modal" data-target="#postRequirement" class="btn btn-sm btn-secondary btn-bot-rad pl-4 pr-4 text-white font-14" data-toggle="tooltip" title="Not a member yet, no problem!">Post Your Requirement</a>
          <small class="text-muted font-10">Not a member yet, no problem!</small>
        </div>

        <div class="col-md-4 col-lg-3 bg-primary text-center Btn-Rad-TL" id="rad_top_btn">
          <a href="{{url('/get-listed')}}" class="btn btn-sm btn-primary text-white border-0 mr-3 font-14">Get Listed</a>
          <a href="{{url('/events')}}" class="btn btn-sm btn-primary text-white border-0 font-14">Industrial Events</a>
        </div>
      </div>
      --}}

      <a class="navbar-brand" href="{{url('/')}}">
        <img src="{{ config('app.url') }}img/main-logo.png" height="60" class="d-inline-block align-middle" alt="Logo" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse mr-5 mt-4" id="navbarSupportedContent">
        <div class="searchForm1">
          <!-- // MAIN SEARCH -->          
          {{Form::open(['url' => 'search', 'class' => 'form-inline my-2 my-lg-0', 'id'=>'searchForm' ])}}
          <div class="input-group input-group-sm ml-4">
            <input type="text" name="q" class="form-control" id="autoComplete" required placeholder="Search Products & Manufacturers...">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-secondary" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i></button>
              </span>
            </div>
            {{Form::close()}} 
            <!-- MAIN SEARCH // -->
          </div>

          <ul class="navbar-nav ml-auto mt-1">




            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Products
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                <div class="row">
                  <div class="col-md-12">                
                   <div id="accordion">
                    <?php $i=1; ?>
                    <?php $cat = getcatView(22); ?>
                    @foreach($cat as $val)

                    <div class="card col-lg-12">

                      <div class="card-header" id="heading{{$i}}">
                        <h2>
                          <a class="collapsed" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                            {{$val['name']}}
                          </a>
                        </h2>
                      </div>

                      <?php $childs = getcatView($val['id']);?>
                      @if(@$childs)
                      <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordion">
                       @foreach($childs as $child)                       
                       <?php 
                       $count = DB::table('products')->where('category_id',$child['id'])->count();
                       ?>
                       <div class="card-body">
                        <a href="{{url('categories')}}{{'/'.$child->slug}}"> 
                          <p>{{ucwords(strtolower($child['name']))}} <!--<span class="text-muted ml-1 pull-right">({{$count}})</span>--></p></a>                      
                        </div>
                        @endforeach
                      </div>
                      @endif

                      <?php $i=$i+1; ?>

                    </div> 
                    @endforeach
                  </div>

                </div>


              </div>

              <!--  /.container  -->


            </div>
          </li>   

          <li class="nav-item {!! (Request::is('suppliers') ? 'active' : '') !!}">
            <a class="nav-link" href="{{url('suppliers')}}">Suppliers</a>
          </li> 
          {{--   <li class="nav-item {!! (Request::is('events*') ? 'active' : '') !!}">
            <a class="nav-link" href="{{url('/events')}}">Events</a>
          </li> --}}
          <li class="nav-item {!! (Request::is('projects*') ? 'active' : '') !!}">
            <a class="nav-link" href="{{url('/projects')}}">Projects</a>
          </li>
          <li class="nav-item {!! (Request::is('tenders*') ? 'active' : '') !!}">
            <a class="nav-link" href="{{url('/tenders')}}">Tenders</a>
          </li>

          <li class="nav-item dropdown {!! (Request::is('articles*') || Request::is('interviews*') || Request::is('news*') || Request::is('pressreleases*') || Request::is('whitepapers*') || Request::is('reports*') ? 'active' : '') !!}">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Insights </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="dropdown-item" href="{{url('/articles')}}">Articles</a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="{{url('/interviews')}}">Interviews</a>
                </li>
                {{--   <li class="nav-item">
                  <a class="dropdown-item" href="{{url('/news')}}">News</a>
                </li> --}}
                <li class="nav-item">
                  <a class="dropdown-item" href="{{url('/pressreleases')}}">Press Releases</a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="{{url('/whitepapers')}}">Whitepapers</a>
                </li>
                 <!--  <li class="nav-item">
                    <a class="dropdown-item" href="{{url('/reports')}}">Reports</a>
                  </li> -->
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>     

    </header>

    <!-- Begin page content -->
    <div role="main" id="profile">
      
      <div class="bg-white sticky-top">
        <!-- // Company Heading -->
        <div class="container-fluid bg-white">
          <div class=" pt-2 ">
            <div class="row">
              <div class="col-12 col-sm-5 col-md-2 col-lg-2 ">
                <img src="{{ config('app.url') }}suppliers/{{str_slug($companyprofile->company->comp_name)}}/{{$companyprofile->company->comp_logo}}" alt="{{$companyprofile->company->comp_name}}" title="{{$companyprofile->company->comp_name}}" class="img-fluid mt-1 mb-1" width="150px" /  >
              </div>
              <div class="col-sm-1 col-md-3 col-lg-5 d-none d-sm-block">
               <div class="searchForm2 mt-5">

               </div>
             </div>

             <div class="col-11 col-sm-6 col-md-7 col-lg-5 pb-2">
              <h1 class="title display-5 pt-1">{{$companyprofile->company->comp_name}}  
                <a href="javascript:void(0)" onclick="trackOutboundLink('{{$companyprofile->company->track_url}}'); return false;">
                  <span class="small ml-1"><i class="fa fa-external-link text-blue" aria-hidden="true"></i></span>
                </a>
              </h1>
              <span class="small text-secondary address-p" >{!!$companyprofile->company->address!!}</span>
              <div class="pt-1">
                <a href="{{$companyprofile->company->linkedin? $companyprofile->company->linkedin : 'javascript:void(0)'}}" target="_blank">
                  <img src="{{ config('app.url') }}images/linkedin-img.png" alt="" class="img-fluid rounded-circle mr-1" width="25">
                </a>
                <a href="{{$companyprofile->company->twitter? $companyprofile->company->twitter : 'javascript:void(0)'}}" target="_blank">
                  <img src="{{ config('app.url') }}images/twitter-img.png" alt="" class="img-fluid rounded-circle mr-1" width="25">
                </a>
                <a href="{{$companyprofile->company->facebook? $companyprofile->company->facebook : 'javascript:void(0)'}}" target="_blank">
                  <img src="{{ config('app.url') }}images/facebook-img.png" alt="" class="img-fluid rounded-circle" width="25">
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- Company Heading // -->

      <!-- // Profile Nav -->
      <nav class="navbar navbar-expand-lg navbar-dark pt-1 pb-1">
        <div class="container">
          <!-- <a class="navbar-brand" href="#">Profile Menu</a> -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#subnav" aria-controls="subnav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <?php $active_menus = json_decode($companyprofile->active_menus); ?>
          <div class="collapse navbar-collapse" id="subnav">
            <ul class="navbar-nav mr-auto">
             <li class="nav-item @if(\Request::segment('1')=='products') active @endif">
              @if(@$companyprofile->pproduct->count() != 0)
              <a class="nav-link" href="{{url('demoproducts/'.$companyprofile->url)}}">Products</a>
              @else 
              <a class="nav-link disabled" >Products</a>
              @endif
            </li>
            <li class="nav-item @if(\Request::segment('1')=='catalogue') active @endif">
             @if(@$companyprofile->pcatalog->count() != 0)
             <a class="nav-link" href="{{url('democatalogue/'.$companyprofile->url)}}">Catalogues</a>

             @else 
             <a class="nav-link disabled" >Catalogues</a>
             @endif
           </li>
           <li class="nav-item @if(\Request::segment('1')=='pressrelease') active @endif">
             @if(@$companyprofile->ppress->count() != 0)
             <a class="nav-link" href="{{url('demopressrelease/'.$companyprofile->url)}}">Press Release</a>
             @else 
             <a class="nav-link disabled" >Press Release</a>
             @endif
           </li>
           <li class="nav-item @if(\Request::segment('1')=='whitepaper') active @endif">
            @if(@$companyprofile->pwp->count() != 0)
            <a class="nav-link " href="{{url('demowhitepaper/'.$companyprofile->url)}}">White Papers</a>
            @else  
            <a class="nav-link disabled" >White Papers</a>
            @endif
          </li>
          <li class="nav-item @if(\Request::segment('1')=='video') active @endif">
            @if(@$companyprofile->pvideo->count() != 0)
            <a class="nav-link" href="{{url('demovideo/'.$companyprofile->url)}}">Videos</a>
            @else 
            <a class="nav-link disabled" >Videos</a>
            @endif
          </li>

          <li class="nav-item"><a class="nav-link disabled" >Events</a></li>
          <li class="nav-item"><a class="nav-link disabled" >Projects</a></li>
          <li class="nav-item"><a class="nav-link disabled" >Interviews</a></li>       

        </ul>  

        <a class="btn btn-sm btn-radius my-2 my-lg-0 pl-4 pr-4 pt-0 pb-0" href="{{url('suppliers/'.$companyprofile->url)}}" role="button">Profile</a>         
      </div>
    </div>  
  </nav>
  <!-- Profile Nav // -->
</div>


@yield('content')

<div class="mt-3"></div>  

<div id="alertModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title text-danger">Error</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>
    <div class="modal-body">
      <p class="">Please fill the all required fields....!!</p>


    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

   </div>
 </div>
</div>
</div>
<!-- // FOOTER -->
<footer>
  <div class="container">
    <div class="row">
      <!-- // FOOTER-LOGO -->
      <div class="col-lg-2 pt-4 pb-1">
        <div class="footer-widget">
          <h5>Powered By<span class="head-line"></span></h5>
        </div>
        <a href="https://www.ochre-media.com" target="_blank">
          <img src="{{ config('app.url') }}/img/ochre-media-logo.png" width="70" alt="Ochre Media Group" title="Ochre Media Group" class="img-fluid mt-2" />
        </a> 
        <!-- <p class="mt-3 pb-3"><small>Ochre Media Pvt Ltd.</small></p> -->
      </div>
      <!-- FOOTER-LOGO // -->

      <!-- // FOOTER-LINKS -->
      <div class="col-lg-8 pt-4 pb-1">
        <div class="footer-widget">
          <h5>Quick Links<span class="head-line"></span></h5>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <ul>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/post-requirement')}}" target="_blank">Post your Requirement</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/postevent')}}" target="_blank">Event Registration</a>
              </li>
              <!-- <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/registration')}}" target="_blank">Newsletter Signup</a>
              </li> -->
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/events-newsletters')}}" target="_blank">Event Newsletters</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <ul>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/get-listed')}}" target="_blank">Get Listed</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('mediapack-download')}}" target="_blank">Mediapack</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/clientele')}}" target="_blank">Clientele</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/registration')}}" target="_blank">e-Newsletters</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <ul>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{config('app.blogurl')}}" target="_blank">Blog</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/partners')}}" target="_blank">Our Partners</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/aboutus')}}" target="_blank">About Us</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('contactus')}}" target="_blank">Contact Us</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <ul>
            <!-- <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/suppliers')}}" target="_blank">Suppliers</a>
              </li>   -->  
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/sitemap')}}" target="_blank">Sitemap</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="{{url('/terms-conditions')}}" target="_blank">Terms &amp; Conditions</a>
              </li>
              <li><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;
                <a href="https://www.ochre-media.com/webprint.html" target="_blank">Our Other Industries</a>
              </li>      

            </ul>
          </div>
        </div>
      </div>

      <!-- <div id="myModalpopup" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content p-0">           
            <div class="modal-body p-0">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <a href="http://track.plantautomation-technology.com/20190528052301808254698" target="_blank">
               <img src="{{ config('app.url') }}images/ae-popup-banner.jpg" width="100%">
             </a> 
           </div>          
         </div>
        </div>
      </div> -->

      
   <!-- FOOTER-LINKS // -->

   <!-- // FOOTER-SOCIAL MEDIA -->
   <div class="col-lg-2 pt-4 pb-1">
    <div class="footer-widget">
      <h5>Get in Touch<span class="head-line"></span></h5>
    </div>
    <div class="social-widget pt-2 text-center">
      <ul class="social-icons">
        <li>
          <a target="_blank" title="Facebook" class="facebook" href="{{ config('app.furl') }}"><i class="fa fa-facebook"></i></a>
        </li>
        <li><a target="_blank" title="Google Plus" class="google" href="{{ config('app.gurl') }}"><i class="fa fa-google-plus"></i></a></li>
      </ul>
      <ul class="social-icons">
        <li><a target="_blank" title="Twitter" class="twitter" href="{{ config('app.turl') }}"><i class="fa fa-twitter"></i></a></li>

        <li><a target="_blank" title="LinkedIn" class="linkdin" href="{{ config('app.lurl') }}"><i class="fa fa-linkedin"></i></a></li>
      </ul>   
      <!--  <ul class="social-icons"></ul>  -->                      
    </div>
  </div>
  <!-- FOOTER-SOCIAL MEDIA // -->       

  <!-- // Copyright-Section -->
  <div class="col-lg-12">
    <div class="copyright-section">                
      <p class="pt-3 text-center">&copy; Ochre Media Pvt Ltd., {!! date('Y') !!}. All rights reserved.</p>
    </div>
  </div> 
  <!-- Copyright-Section // -->        
</div>  
</div>  
</footer>
<!-- FOOTER // -->

<!-- Modal -->
<div class="modal fade" id="postRequirement" tabindex="-1" role="dialog" aria-labelledby="postRequirementTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-blue" id="postRequirementTitle">Post Your Requirement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<!-- Post Your Requirement Modal // -->

<!-- success modal -->
<div id="postRequirementSuccess" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-success">Success</h4>
        <button type="button" class="close" onClick="{{url('/') .'/'. session('slug')}}">&times;</button>

      </div>
      <div class="modal-body">
        <p class="">{!!session('message')!!}</p>
        <p>Sincerely Plantautomation Technology</p>
        <p class="mb-0">Regards,</p>
        <p class="mb-0">Client Success Team (CRM),</p>
        <img src="{{ config('app.url')}}img/main-logo.png" width="150px">
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-default" onClick="location.href=location.href">Close</button> --}}

        <a href="{{url('/') .'/'. session('slug')}}" class="btn btn-info text-right">Close</a>
      </div>
    </div>
  </div>
</div>



<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
{{-- <script src="{{ config('app.url') }}js/jquery-3.2.1.slim.min.js" ></script> --}}
<script src="{{ config('app.url') }}js/popper.min.js" ></script>
<script src="{{ config('app.url') }}js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {

    autoComplete();


    if ($(window).width() > 1100) {

      var form = "<form method='POST' action='https://www.packaging-labelling.com/search' accept-charset='UTF-8' class='form-inline my-2 my-lg-0' id='searchForm' _lpchecked='1'><input name='_token' type='hidden' value='{{csrf_token()}}'><div class='input-group input-group-sm ml-4 '><input type='text' name='q' class='form-control ui-autocomplete-input' id='autoComplete' required='' placeholder='Search Products &amp; Manufacturers...' autocomplete='off'><span class='input-group-btn'><button class='btn btn-sm btn-secondary' type='submit'><i class='fa fa-search' aria-hidden='true'></i></button></span></div></form>";


      $(window).scroll(function(){
        var scrollTop = $(window).scrollTop();
        if($(this).scrollTop()>= '100'){             
              // $('#stickyPostRequirement').removeClass('offset-lg-7',{duration:100}).addClass('offset-lg-2',{duration:200});
              $('#stickyPostRequirement').removeClass('offset-lg-7',{duration:100}).css({'margin-left':'16.666667%', 'transition' : '500ms'});
              $('.searchForm1').empty();
              $('.searchForm2').html(form);
              $('#rad_top_btn').addClass('Btn-Rad-BR',{duration:300});
              

            }else{
              // $('#stickyPostRequirement').removeClass('offset-lg-2',{duration:200}).addClass('offset-lg-7',{duration:100});
              $('#stickyPostRequirement').css({ 'margin-left':'58.333333%', 'transition' : '500ms'});
              $('.searchForm2').empty();
              $('.searchForm1').html(form);
              $('#rad_top_btn').removeClass('Btn-Rad-BR',{duration:300});
              
            }
          });
    }



    function autoComplete(){
     src = "{{ url('searchajax') }}";
     $("#autoComplete").autocomplete({    
      source: function(request, response) {
        $.ajax({
          url: src,
          dataType: "json",
          data: {
            term : request.term
          },
          success: function(data) {
            response(data);

          }
        });
      },
      minLength: 3,
      autoFill: true,
      select: function (event, ui) {
        $('#autoComplete').val(ui.item.value);
        $('form').submit();
                  // var label = ui.item.label;
                  // var value = ui.item.value;

               //store in session
               // document.valueSelectedForAutocomplete = value 
             }

           });

   }
 });    


</script>    
@if(session('requirement') == 'success') 
<script type="text/javascript">
  $('#postRequirementSuccess').modal('show');   

</script>
@endif   


<!-- <script type="text/javascript">       
  jQuery(document).ready(function($){  
   alignModal();
   if (sessionStorage.getItem('advertOnce') !== 'true') {
    $('#myModalpopup').modal({backdrop: 'static', keyboard: false});
    sessionStorage.setItem('advertOnce','true');
   }     
  });

  function alignModal(){
   var modalDialog = $(".modal-dialog");  }
</script> -->

<script>
/**
* Function that tracks a click on an outbound link in Analytics.
* This function takes a valid URL string as an argument, and uses that URL string
* as the event label. Setting the transport method to 'beacon' lets the hit be sent
* using 'navigator.sendBeacon' in browser that support it.
*/
var trackOutboundLink = function(url) {
 ga('send', 'event', 'outbound', 'click', url, {'transport': 'beacon','hitCallback': function(){
  window.open(url,'_blank');
}
});  
}


</script> 
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/5828206.js"></script>
<!-- End of HubSpot Embed Code -->

@yield('scripts')
</body>
</html>    

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">    
    <link rel="stylesheet" href="{{ asset('css/superhero-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magicsuggest.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->


    <style type="text/css">
    #header-nav .navbar-nav > li > .dropdown-menu {
    margin-top: 0;
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    background-color: #df691a;
}

#mega-nav .navbar-nav > li{width: auto;}
#mega-nav .navbar-nav>li>.dropdown-menu {
  margin-top: 1px;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}

#mega-nav .navbar-default .navbar-nav>li>a {
  width: 300px;
  font-weight: bold;
}

#mega-nav .mega-dropdown {
  position: static !important;
  width: 100%;
}


#mega-nav .mega-dropdown-menu {
  padding: 20px 0px;
  width: 100%;
  box-shadow: none;
  -webkit-box-shadow: none;
}

#mega-nav .mega-dropdown-menu > li > ul {
  padding: 0;
  margin: 0;
}

#mega-nav .mega-dropdown-menu > li > ul > li {
  list-style: none;
}

#mega-nav .mega-dropdown-menu > li > ul > li > a {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 1.428571429;
  color: #999;
  white-space: normal;
}

#mega-nav .mega-dropdown-menu > li ul > li > a:hover,
.mega-dropdown-menu > li ul > li > a:focus {
  text-decoration: none;
  color: #444;
  background-color: #f5f5f5;
}

#mega-nav .mega-dropdown-menu .dropdown-header {
  color: #df691a;
  font-size: 18px;
  font-weight: bold;
}

#mega-nav .mega-dropdown-menu form {
  margin: 3px 20px;
}

#mega-nav .mega-dropdown-menu .form-group {
  margin-bottom: 3px;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus{background-color: #273442;}

table a:not(.btn), .table a:not(.btn){color: #000;font-weight: bold;}

</style>
  @yield('style')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" id="header-nav">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                    @if (Auth::guest())
                    @else
                    <?php if (Auth::user()->can('settings')){ ?>
                    <li>
                    <div class="dropdown">
                      <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Settings
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                       <?php if (Auth::user()->can('settings')){ ?>
                        <li><a href="{{route('permissions.index')}}">Permission</a></li>                  
                        <li><a href="{{route('roles.index')}}">Role</a></li>                 
                        <li><a href="{{route('users.index')}}">Users</a></li>
                        <li><a href="{{route('usersinfo')}}">Clients Info</a></li>
                        <?php } ?>
                      </ul>
                    </div>
                    </li>
                   <?php } ?>
                  @endif
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        
                        @else
                           
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ ucfirst(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    
                 @guest
                    @else
             <div class="container">
                  <nav class="navbar navbar-default" id="mega-nav">
                    <div class="navbar-header">
                      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    </div>
                    <div class="collapse navbar-collapse js-navbar-collapse">
                      <ul class="nav navbar-nav">                    
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Company / Events Management <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>

                          <ul class="dropdown-menu mega-dropdown-menu row">

                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Company</li>
                                <li><a href="{{ url('categories',[],false) }}"> Categories</a></li>
                                <li><a href="{{ url('companies') }}"> Company</a></li>
                                <li><a href="{{ url('companyprofile') }}">Profiles</a></li>
                                <li><a href="{{ url('products') }}">Products</a></li>
                                <li><a href="{{ url('product_landingpages') }}">Product Landingpages</a></li>
                                <li><a href="{{ url('product-keywords') }}">Product Keywords</a></li>
                                <li><a href="{{ url('non-product-keywords') }}">No Product Keywords</a></li>
                                <li><a href="{{ url('companypressrealeses') }}">Pressrealese</a></li>
                                <li><a href="{{ url('companywhitepapers') }}">White papers</a></li>
                                <li><a href="{{ url('companycatalogs') }}">Catalogs</a></li>
                                <li><a href="{{ url('companyvideos') }}">Videos</a></li>
                                 <li><a href="{{ url('companyprojects') }}">Projects</a></li>
                                <li><a href="{{ url('bulkupload') }}">Bulk Companies Upload</a></li>
                                <li><a href="{{ url('company-enquiries') }}">Company Enquiries</a></li>
                                <li><a href="{{ url('enquiries-mapping') }}">Enquiries Mapping</a></li>
                                 <li><a href="{{url('/inactive')}}">InActive Profiles</a></li>
                                 <li><a href="{{url('/enquiries')}}">Send Enquiries</a></li>
                              </ul>
                            </li>
                            <li class="col-sm-4">  
                             <ul>               
                                <li class="dropdown-header">Event Organisers</li>
                                <li><a href="{{ url('eventorganisers') }}"> About</a></li>
                                <li><a href="{{ url('eventorgbrochures') }}"> Brochures</a></li>
                                <li><a href="{{ url('eventorgpressrealese') }}"> Pressrealese</a></li>
                                <li><a href="{{ url('eventorginterviews') }}"> Interviews</a></li>
                                <li><a href="{{ url('eventorgarticles') }}"> Articles</a></li>
                                <li><a href="{{ url('eventorggallery') }}"> Gallery</a></li>
                              
                              </ul>

                           
                            </li>

                              <li class="col-sm-4">  
                             <ul>               
                                <li class="dropdown-header">Product Filter</li>
                                <li><a href="{{ url('tags') }}"> Tags</a></li>
                                <li><a href="{{ url('subtags') }}"> Sub Tags</a></li>
                                
                              
                              </ul>

                           
                            </li>

                             <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Events</li>
                                <li><a href="{{ url('event-categories') }}"> Event Category</a></li>
                                <li><a href="{{ url('events') }}"> Events</a></li>
                                <li><a href="{{ url('eventprofiles') }}"> Profile</a></li>
                                <li><a href="{{ url('eventgallery') }}"> Gallery</a></li>
                                <li><a href="{{ url('eventpressrealese') }}"> Pressrealese</a></li>
                                <li><a href="{{ url('eventspeakers') }}"> Speaker</a></li>
                                <li><a href="{{ url('eventbrochures') }}">Brochure</a></li>
                                <li><a href="{{ url('eventpartners') }}">Partners </a></li>
                              </ul>
                            </li>
                            
                          </ul>
                        </li>                        
                      </ul>
                      <ul class="nav navbar-nav">
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Industry Updates <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Knowledgebank</li>
                               <li><a href="{{ url('articles') }}"> Articles</a></li>
                                <li><a href="{{ url('interviews') }}"> Interviews</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Industry Updates</li>
                               <li><a href="{{ url('news')}}">News</a></li>
                               <li><a href="{{ url('pressreleases')}}">Press Releases</a></li>
                               <li><a href="{{ url('projects')}}">Projects</a></li>
                               <li><a href="{{ url('whitepapers')}}">White Papers</a></li>
                               <li><a href="{{ url('reports')}}">Reports</a></li>
                              </ul>
                            </li>
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Newsletters</li>
                                <li><a href="{{ url('e-newsletters')}}">E-NewsLetter</a></li>
                                <li><a href="{{ url('eventnewsletters')}}">Events Newsletter</a></li>
                                <li><a href="{{ url('clientemailblast')}}">Client Emailblast</a></li>
                                <li><a href="{{ url('mediapack')}}">Media Pack</a></li>
                                 <li><a href="{{ url('productnewsletter')}}">Product-NewsLetter</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Banner & Tracking Management</li>
                                <li><a href="{{url('banners')}}">Banners</a></li>
                                <li><a href="{{ url('trackbanner') }}">Banner Report</a></li>
                                <li><a href="{{ url('trackedm') }}">Edm Report</a></li>
                                 <li><a href="{{ url('trackenewsletter') }}">E-newsletter Report</a></li>
                              </ul>
                            </li>
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Other</li>
                               <li><a href="{{ url('pages') }}"> Pages</a></li>
                               <li><a href="{{ url('productlaunch') }}"> Product Launch</a></li>
                               <li><a href="{{ url('sliders') }}"> Sliders</a></li>
                               <li><a href="{{ url('testimonials') }}">Testimonials</a></li>
                               <li><a href="{{ url('partners') }}">Partners</a></li>
                               <li><a href="{{ url('cmspages') }}">CMS pages</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Tenders</li>
                                <li><a href="{{ url('tenders') }}">Add Tender</a></li>
                                <li><a href="#"></a></li>
                               
                              </ul>
                            </li>
                          </ul>
                        </li>     
                      </ul>
                       <ul class="nav navbar-nav">
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">SEO Suit <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Company</li>
                                <li><a href="{{ url('seopage') }}"> Seo Main Pages</a></li>
                               <li><a href="{{ url('seocompanies') }}"> Seo Company</a></li>  
                                <li class="divider"></li>

                              </ul>
                            </li>
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Event Organiser</li>
                                 <li><a href="{{ url('seoeventorg') }}"> Seo Event Organiser</a></li>
                                <li class="divider"></li>
                                
                              </ul>
                            </li>
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Event Profile</li>
                                  <li><a href="{{url('seoevents') }}"> Seo Event Profile</a></li>
                                <li class="divider"></li>                              
                              </ul>
                            </li>
                          </ul>
                        </li>     
                      </ul>


                        <ul class="nav navbar-nav">
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Automate Data <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="col-sm-4">
                              <ul>
                                <li class="dropdown-header">Company</li>
                                <li><a href="{{ url('movedata') }}">Move Each profile to Live</a></li>
                               <li><a href="{{ url('profilelive') }}">Move Bulk Profiles to Live - URLs</a></li>  
                               <li><a href="{{ url('testtolive') }}">Move Bulk Profiles to Live - Names</a></li>  
                               <li><a href="{{ url('livetotest') }}">Move Bulk Profiles to Test - Names</a></li>  
                               
                                <li class="divider"></li>

                              </ul>
                            </li>
                            <li class="col-sm-4">
                               <ul>
                                <li class="dropdown-header">Companies Demo site</li>
                                <li><a href="{{ url('democompanieslist') }}">Companies List</a></li>
                               
                               
                                <li class="divider"></li>

                              </ul>
                            </li>
                            <li class="col-sm-4">
                             
                            </li>
                          </ul>
                        </li>     
                      </ul>


                           <ul class="nav navbar-nav">
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Track <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="col-sm-4">
                               <ul>               
                                <li class="dropdown-header">Track</li>
                                <li><a href="{{ url('tracklinkgen') }}"> Track link Generation</a></li>
                                <li><a href="{{ url('trackreport') }}"> Url Track Report</a></li>
                               
                              
                              </ul>
                            </li>
                           
                          </ul>
                        </li>     
                      </ul>

                      
                      <ul class="nav navbar-nav pull-right">   
                       <a href="{{url('/promotionleads')}}"><button type="button" class="btn btn-warning"><i class="" aria-hidden="true"></i>Leads</button></a>                    
                         

                         <a href="{{url('/dataexport')}}"><button type="button" class="btn btn-warning"><i class="fa fa-share-square-o" aria-hidden="true"></i> Data Export</button></a>

                        
                      {{--   <a href="{{url('/inactive')}}"><button type="button" class="btn btn-warning"><i class="fa fa-ban" aria-hidden="true"></i> InActive Profiles</button></a> --}}


                        <a href="{{url('/fileupload')}}"><button type="button" class="btn btn-info"> <i class="fa fa-upload"></i> Image Live Link</button></a>

                        @if(Request::segment(1) == 'interviews')                     
                        <a href="{{route('interview.position')}}"><button type="button" class="btn btn-warning">Interview Positions</button></a>
                      
                        @else
                        @endif
                      </ul>
                         <ul class="nav navbar-nav">
                        <li class="dropdown mega-dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">CRM <i class="fa fa-chevron-down text-primary" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="col-sm-4">
                               <ul>               
                                <li class="dropdown-header">CRM</li>
                                <li><a href="{{url('company-history')}}"> Company History</a></li>
                                <li><a href="{{url('enquiries')}}"> Send Enquiries</a></li>
                               <li><a href="{{url('companies')}}"> Companies</a></li>
                              
                              </ul>
                            </li>
                           
                          </ul>
                        </li>     
                      </ul>

                     
                    </div>
                    <!-- /.nav-collapse -->
                  </nav>
                </div>
                @endguest

<div class="container-fluid">   
        <div class="col-md-offset-3 col-md-6">
            @if(session('message'))
            <div class="alert alert-{{ session('message_type') }} alert-dismissible" id="success-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{@session('message')}}

            </div>
            @endif
            @if(session('position_type'))
            <div class="alert alert-{{ session('message_type') }} alert-dismissible" id="success-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{@session('position_type')}}
                 </div>
            @endif
        </div>
    <div class="col-md-12">
             @yield('header')
             @yield('content')
    </div>
      
    </div>

    <!-- Scripts -->
       <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
   <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
   <script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Include Editor style. -->
<script src="{{ url('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

 <script type="text/javascript">
        jQuery(document).on('click', '.mega-dropdown', function(e) {
            e.stopPropagation()
            });
    </script>
     <script>
       
        $(document).ready (function(){
           $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 2000).slideUp(2000, function(){
               $("#success-alert").slideUp(2000);
                });
        });
    </script>
    @yield('scripts')
</body>
</html>

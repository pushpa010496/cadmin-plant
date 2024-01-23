@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Inactive Pages
                    <!-- <a class="btn btn-success pull-right" href="{{ route('categories.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a> -->
                </h3>               
            </div>
             <!-- <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'categories','role'=>'search'])  !!}
              <div id="custom-search-input">
                <div class="input-group col-md-12 pull-right">
                    <input type="text" class="search-query form-control" placeholder="Search" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>

                        </button>
                    </span>
                </div>
              </div>
         {!! Form::close() !!}
        </div> -->
        </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
           <ul>
                                <li><a href="{{ url('inactive-company')}}">Company</a></li>
                                <li><a href="{{ url('inactive-profiles')}}">Profiles</a></li>
                                <li><a href="{{ url('inactive-products')}}">Products</a></li>
                                <li><a href="{{ url('inactive-pressrelease')}}">pressrelease</a></li>
                                <li><a href="{{ url('inactive-whitepaper')}}">White Papers</a></li>
                                <li><a href="{{ url('inactive-catalog')}}">Catalogs</a></li>
                                <li><a href="{{ url('inactive-video')}}">Videos</a></li>
                                
                              </ul>
                
        </div>
    </div>
    </div>

@endsection 
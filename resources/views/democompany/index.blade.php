@extends('../layouts/pages')
@section('style')
 <style type="text/css">
 	.event-bg {
    background-image: url("{{config('app.url')}}img/events/event-list/event-listing-bg.jpg");
	}
 </style>
@endsection
@section('content')

 <!-- Begin page content -->
    <div role="main" id="company-profile">

      <div class="container-fluid pl-0 pr-0">
        <div class="event-bg">
          <h1 class="text-center text-uppercase">Suppliers</h1>
        </div>
      </div>
      <!-- // Event Listing -->
      <div class="container pb-3">
        <div class="row">
          <div class="col-lg-9 pt-4"> 

            <!-- // Suppliers -->
            <div class="container">
              <div class="row" id="product">
              @foreach($companyprofile as $cp)
                <div class="col-lg-3 mb-4">
                  <div class="product div-scal"> 
                    <a href="{{url('suppliers/'.$cp->url)}}">
                      <img class="img-fluid" src="{{ config('app.url') }}suppliers/{{ str_slug($cp->company->comp_name) }}/{{$cp->company->comp_logo}}" alt="{{$cp->title}}" title="{{$cp->title}}" />
                    </a>                                           
                    <h2 class="bg-white"><a href="{{url('suppliers/'.$cp->url)}}">{!!$cp->title!!}</a></h2>
                  </div>
                </div>
     			    @endforeach               

              </div>
            </div>  
            <!-- Suppliers // -->
          </div>

          <div class="col-lg-3 pt-4 pb-3">
            <div class="pb-4">
              <a href="{{url('newsletter-signup')}}"><button type="button" class="btn btn-block btn-success"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; Newsletter
              </button></a>
            </div>

            <div id="form-sticky">
              <div class="bg-light p-2 border border-secondary"> 
                <h3 class="text-center title mb-3">Post Your Project</h3>
                 @if(session('message'))
                    <div class="alert alert-{{ session('message_type') }} alert-dismissible" id="success-alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
			                        {{@session('message')}}
			                    </div>
			                @endif
			               
			                  <div class="form-group">
			                    {{Form::text('name', null,['required'=>'required','class'=>'form-control','placeholder'=>'Name*'])}}
			                    <input type="hidden" name="page" value="Suppliers">
			                    <input type="hidden" name="slug" value="{{\Request::segment(2)}}">
			                  </div>
			                  <div class="form-group">
			                   {{Form::text('company', null,['required'=>'required','class'=>'form-control','placeholder'=>'Company Name*'])}}
			                  </div>
			                  <div class="form-group">
			                    <select class="form-control" name="country">
			                      <option>Select Country</option>
			                    @foreach($countries as $country)
			                      <option value="{{$country->country_name}}">{{$country->country_name}}</option> 
			                    @endforeach
			                    </select>
			                  </div>
			                  <div class="form-group">
			                   {{Form::text('email', null,['required'=>'required','class'=>'form-control','placeholder'=>'Email*'])}}
			                  </div>
			                  <div class="form-group">
			                    {{Form::text('telephone', null,['required'=>'required','class'=>'form-control','placeholder'=>'Telephone*'])}}
			                  </div>
			                  <div class="form-group">
			                    {{Form::textarea('message', null,['rows'=>3,'class'=>'form-control','placeholder'=>'Write Message...'])}}
			                  </div>
			                 <div class="form-group">
			                   {!! Form::captcha() !!}
			                </div>
			                <button type="submit"  class="btn btn-primary btn-block">Submit</button>			                
			              </div>  
                    <img src="{{ config('app.url') }}/img/ssl-logo.png" alt="SSL Secure Connection" width="100" class="img-fluid pull-right mt-1 mb-1" />
              <div class="clearfix"></div>
			            </div>
			          </div>
			        </div>
			        </div>
			        {!! Form::close() !!}
              </div>  
            </div>
          </div>
        </div>
      </div>
      <!-- Event Listing // -->
    </div>
@endsection
@section('scripts')

   
@endsection
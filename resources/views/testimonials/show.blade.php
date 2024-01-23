@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>testimonial / Show #{{$testimonial->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('testimonials.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('testimonials.edit', $testimonial->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
           
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Client Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->client_name }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Company Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->company_name }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Testimonial Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($testimonial->image)
                  <img width="200" src="<?php echo config('app.url'); ?>testimonial/<?php echo $testimonial->image;?>">
                  @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->img_alt }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->img_title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Designation</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->designation }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Adv Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $testimonial->adv_description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($testimonial->active_flag == 1)
                    Active
                    @elseif($testimonial->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="testimonial icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($testimonial->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($testimonial->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

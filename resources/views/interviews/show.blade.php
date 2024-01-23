@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Interview / Show #{{$interview->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('interviews.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('interviews.edit', $interview->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Interview Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->name }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Interview Url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->interviews_url }}</h5>
              </div>


               <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Interview Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($interview->image)
                  <img width="100" src="<?php echo config('app.url'); ?>interview/<?php echo $interview->image;?>">
                  @endif
                </h5>
              </div>             
             
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Image Destination Url:</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->img_destination_url }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Image Alt tag:</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->img_alt }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Image Title tag:</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->img_title }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Company:</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->company }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Designation:</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->designation }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Interview Small image</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($interview->small_image)
                  <img width="200" src="<?php echo config('app.url'); ?>interview/<?php echo $interview->small_image;?>">
                  @endif</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $interview->description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Add Questions</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ strip_tags($interview->add_questions) }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($interview->active_flag == 1)
                    Active
                    @elseif($interview->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="interview icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($interview->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($interview->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

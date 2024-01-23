@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Gallery / Show #{{$eventspeaker->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventspeakers.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventspeakers.edit', $eventspeaker->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventspeaker->event->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventspeaker->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventspeaker->image)
                  <img width="100" src="<?php echo config('app.url'); ?>event/speaker/<?php echo $eventspeaker->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Speaker Profile Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventspeaker->speaker_profile_img)
                  <img width="200" src="<?php echo config('app.url'); ?>event/speaker/<?php echo $eventspeaker->speaker_profile_img;?>">
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventspeaker->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventspeaker->img_title }}</h5>
              </div>
             </div>

             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Designation</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventspeaker->designation }}</h5>
              </div>
             </div>

             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Type:</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventspeaker->type == 0)
                    Other
                    @elseif($eventspeaker->type == 1)
                    PCD Conference Speaker
                    @elseif($eventspeaker->type == 2)
                    ADF Conference Speaker
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Show on Profile ?:</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventspeaker->show_on_profile == 1)
                    Yes
                    @elseif($eventspeaker->show_on_profile == 0)
                    No
                    @endif
                </h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventspeaker->active_flag == 1)
                    Active
                    @elseif($eventspeaker->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventspeaker icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventspeaker->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventspeaker->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

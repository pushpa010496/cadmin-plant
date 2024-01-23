@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Pressrealese / Show #{{$eventpressrealese->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventpressrealese.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventpressrealese.edit', $eventpressrealese->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventpressrealese->event->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventpressrealese->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventpressrealese->image)
                  <img width="200" src="<?php echo config('app.url'); ?>event/pressrealese/<?php echo $eventpressrealese->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventpressrealese->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventpressrealese->img_title }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventpressrealese->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>event/pressrealese/<?php echo $eventpressrealese->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventpressrealese->description)
                  {{$eventpressrealese->description}}
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventpressrealese->active_flag == 1)
                    Active
                    @elseif($eventpressrealese->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpressrealese icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventpressrealese->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventpressrealese->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Organiser Pressrealese / Show #{{$eventorgpressrealese->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventorgpressrealese.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventorgpressrealese.edit', $eventorgpressrealese->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorgpressrealese->eventorg->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorgpressrealese->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorgpressrealese->image)
                  <img width="100" src="<?php echo config('app.url'); ?>event/organiser/pressrealese/<?php echo $eventorgpressrealese->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorgpressrealese->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorgpressrealese->img_title }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorgpressrealese->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>event/organiser/pressrealese/<?php echo $eventorgpressrealese->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorgpressrealese->description)
                  {!!$eventorgpressrealese->description!!}
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventorgpressrealese->active_flag == 1)
                    Active
                    @elseif($eventorgpressrealese->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorgpressrealese icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventorgpressrealese->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventorgpressrealese->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Organiser Interviews / Show #{{$eventorginterviews->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventorginterviews.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventorginterviews.edit', $eventorginterviews->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorginterviews->eventorg->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorginterviews->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorginterviews->image)
                  <img width="100" src="<?php echo config('app.url'); ?>event/organiser/interview/<?php echo $eventorginterviews->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorginterviews->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorginterviews->img_title }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorginterviews->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>event/organiser/interview/<?php echo $eventorginterviews->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorginterviews->description)
                  {!!$eventorginterviews->description!!}
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventorginterviews->active_flag == 1)
                    Active
                    @elseif($eventorginterviews->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorginterviews icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventorginterviews->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventorginterviews->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

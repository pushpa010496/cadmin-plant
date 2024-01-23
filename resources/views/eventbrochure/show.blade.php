@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Brochure / Show #{{$eventbrochure->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventbrochures.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventbrochures.edit', $eventbrochure->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventbrochure->event->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventbrochure->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventbrochure->image)
                  <img width="200" src="<?php echo config('app.url'); ?>event/brochure/<?php echo $eventbrochure->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventbrochure->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventbrochure->img_title }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventbrochure->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>event/brochure/<?php echo $eventbrochure->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
            
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventbrochure->active_flag == 1)
                    Active
                    @elseif($eventbrochure->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventbrochures icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventbrochure->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventbrochure->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Partner / Show #{{$eventpartner->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventpartners.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventpartners.edit', $eventpartner->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventpartner->event->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventpartner->name }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpartners icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventpartner->image)
                  <img width="200" src="<?php echo config('app.url'); ?>event/partner/<?php echo $eventpartner->image;?>">
                  @endif
                </h5>
              </div>
             </div>
              
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpartners icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventpartner->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpartners icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventpartner->img_title }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpartners icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventpartner->active_flag == 1)
                    Active
                    @elseif($eventpartner->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventpartners icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventpartner->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventpartner->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

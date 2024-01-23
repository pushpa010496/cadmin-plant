@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Organiser Gallery / Show #{{$eventorggallery->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventorggallery.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventorggallery.edit', $eventorggallery->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorggallery->eventorg->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventorggallery->title }}</h5>
              </div>
            </div>

           
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Small Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorggallery->small_img)
                  <img width="200" src="<?php echo config('app.url'); ?>event/organiser/gallery/<?php echo $eventorggallery->small_img;?>">
                  @endif
                </h5>
              </div>
             </div>
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Big Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventorggallery->big_img)
                  <img width="200" src="<?php echo config('app.url'); ?>event/organiser/gallery/<?php echo $eventorggallery->big_img;?>">
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorggallery->img_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventorggallery->img_title }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventorggallery->active_flag == 1)
                    Active
                    @elseif($eventorggallery->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventorggallery icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventorggallery->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventorggallery->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

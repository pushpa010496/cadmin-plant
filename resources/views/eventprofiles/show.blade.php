@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Event Profile / Show #{{$eventprofile->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('eventprofiles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('eventprofiles.edit', $eventprofile->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Event Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventprofile->event->name}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>longitude</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventprofile->longitude }}</h5>
              </div>
            </div>

             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>latitude</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->latitude }}</h5>
              </div>
             </div>

             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>register_btn_url </h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->register_btn_url  }}</h5>
              </div>
             </div>

             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>video</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->video }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Exibitors Profile</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $eventprofile->exibitors_profile !!}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>visitor_profile</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->visitor_profile }}</h5>
              </div>
             </div>
              <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>eventprofile Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($eventprofile->org_logo)
                  <img width="200" src="<?php echo config('app.url'); ?>event/profile/<?php echo $eventprofile->org_logo;?>">
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_logo_alt }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_logo_title }}</h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>org address</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_address }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>phone</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_contactno }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>email</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_email }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>web link</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $eventprofile->org_website }}</h5>
              </div>
             </div>
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>active menus</h5>
              </div>
              <div class="col-md-9">
                <h5>
                   <?php $active_menus = json_decode($eventprofile->active_menus); ?>
                     @if(@$active_menus->brochure==2) Brochure<br>  @endif  
                     @if(@$active_menus->speakers==2) Speakers <br>@endif 
                     @if(@$active_menus->exhibitors==2) Exhibitors <br>@endif
                     @if(@$active_menus->gallery==2) Gallery <br> @endif 
                     @if(@$active_menus->pressrelease==2) pressrelease <br>@endif 
                     @if(@$active_menus->partners==2) partners @endif 
                </h5>
              </div>
             </div>
             
             
            
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Exhibitor description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{$eventprofile->exhibitor_description}}
                </h5>
              </div>
             </div>
             
             
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($eventprofile->active_flag == 1)
                    Active
                    @elseif($eventprofile->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="eventprofile icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($eventprofile->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($eventprofile->created_at)) }}</h5>
              </div>
            </div>
       </div>
    </div>
       
     
  
@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Partner / Show #{{$partner->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('partners.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('partners.edit', $partner->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
            <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>partner type</h5>
              </div>
              <div class="col-md-9">
                @if($partner->type == 1)
                <h5>Online Partners</h5>
                @elseif($partner->type == 2)
               <h5> Media Partners</h5>
                @elseif($partner->type == 3)
                 <h5> Group Partners</h5>
                @elseif($partner->type == 4)
                <h5>Association Partners</h5>
                @endif

              </div>
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>partner Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $partner->title }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>partner url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $partner->partner_url }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>partner Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($partner->image)
                  <img width="200" src="<?php echo config('app.url'); ?>partner/<?php echo $partner->image;?>">
                  @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $partner->img_alt }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $partner->img_title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>partner Small image</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($partner->home_logo)
                  <img width="200" src="<?php echo config('app.url'); ?>partner/<?php echo $partner->home_logo;?>">
                  @endif</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($partner->active_flag == 1)
                    Active
                    @elseif($partner->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="partner icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($partner->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($partner->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

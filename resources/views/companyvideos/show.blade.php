@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Company Video / Show #{!!$companyvideo->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('companyvideos.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('companyvideos.edit', $companyvideo->id)  !!}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

  <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Company Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$companyvideo->company->comp_name !!}</h5>
             </div> 
          </div>
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Profile Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$companyvideo->compprofile->title !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companyvideo->title  !!}</h5>
             </div> 
          </div>
      
            <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="companyvideos icon"></i>Video</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($companyvideo->video)
                  <a target="_blank" href="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companyvideo->company->comp_name);?>/video/<?php echo $companyvideo->video;?>">View Video file</a>
                  @endif
                </h5>
              </div>
             </div>
         
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventvideo icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($companyvideo->active_flag == 1)
                    Active
                    @elseif($companyvideo->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventvideo icon"></i>Created Date</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! date('j F Y', strtotime($companyvideo->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($companyvideo->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventvideo icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$companyvideo->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

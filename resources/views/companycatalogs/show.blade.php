@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Company Profile / Show #{!!$companycatalog->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('companyprofile.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('companyprofile.edit', $companycatalog->id)  !!}">
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
                  <h5>{!! @$companycatalog->company->comp_name !!}</h5>
             </div> 
          </div>
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Profile Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$companycatalog->compprofile->title !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companycatalog->title  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="companycatalogs icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($companycatalog->image)
                  <img width="100" src="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companycatalog->company->comp_name);?>/catalog/<?php echo $companycatalog->image;?>">
                  @endif
                </h5>
              </div>
             </div>
            <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="companycatalogs icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($companycatalog->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companycatalog->company->comp_name);?>/catalog/<?php echo $companycatalog->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Alt Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companycatalog->alt_tag  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companycatalog->title_tag !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($companycatalog->active_flag == 1)
                    Active
                    @elseif($companycatalog->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created Date</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! date('j F Y', strtotime($companycatalog->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($companycatalog->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$companycatalog->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

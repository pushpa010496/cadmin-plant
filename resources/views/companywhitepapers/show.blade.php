@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Company Profile / Show #{!!$companywhitepaper->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('companyprofile.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('companyprofile.edit', $companywhitepaper->id)  !!}">
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
                  <h5>{!! @$companywhitepaper->company->comp_name !!}</h5>
             </div> 
          </div>
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Profile Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$companywhitepaper->compprofile->title !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companywhitepaper->title  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="companywhitepapers icon"></i> Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($companywhitepaper->image)
                  <img width="100" src="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companywhitepaper->company->comp_name);?>/whitepaper/<?php echo $companywhitepaper->image;?>">
                  @endif
                </h5>
              </div>
             </div>
            <div class="row">
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="companywhitepapers icon"></i>PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($companywhitepaper->pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companywhitepaper->company->comp_name);?>/whitepaper/<?php echo $companywhitepaper->pdf;?>">View PDF file</a>
                  @endif
                </h5>
              </div>
             </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Alt Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companywhitepaper->alt_tag  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companywhitepaper->title_tag !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($companywhitepaper->active_flag == 1)
                    Active
                    @elseif($companywhitepaper->active_flag == 0)
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
                <h5>{!! date('j F Y', strtotime($companywhitepaper->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($companywhitepaper->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$companywhitepaper->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

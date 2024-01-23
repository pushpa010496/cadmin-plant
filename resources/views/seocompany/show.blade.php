@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Company Profile / Show #{!!$seocompany->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('seocompanies.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('seocompanies.edit', $seocompany->id)  !!}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

  <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Company Profile Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$seocompany->seocompanypro->title !!}</h5>
             </div> 
          </div>
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Page</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$seocompany->pages !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_title  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_keywords</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_keywords  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_description</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_description  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>og_title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->og_title  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>og_description</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->og_description  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>og_keywords</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->og_keywords  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>og_image</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->og_image  !!}</h5>
             </div> 
          </div>
           <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>og_video</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->og_video  !!}</h5>
             </div> 
          </div> <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_region</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_region  !!}</h5>
             </div> 
          </div> <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_position</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_position  !!}</h5>
             </div> 
          </div> <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>meta_icbm</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $seocompany->meta_icbm  !!}</h5>
             </div> 
          </div>  
             <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($seocompany->active_flag == 1)
                    Active
                    @elseif($seocompany->active_flag == 0)
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
                <h5>{!! date('j F Y', strtotime($seocompany->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($seocompany->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$seocompany->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

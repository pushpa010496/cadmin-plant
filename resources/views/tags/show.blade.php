@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Company Profile / Show #{!!$companyprofile->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('companyprofile.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('companyprofile.edit', $companyprofile->id)  !!}">
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
                  <h5>{!! @$companyprofile->company->comp_name !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companyprofile->title  !!}</h5>
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Description</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companyprofile->description  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Profile URL</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $companyprofile->url  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>active menus</h4>
              </div>
              <div class="col-md-9">
                <h5>
                   <?php $active_menus = json_decode($companyprofile->active_menus); ?>
                   <ul>
                     @if(@$active_menus->whitepapers==2) <li> Whitepapers<br> </li> @endif  
                     @if(@$active_menus->catalogs==2)<li> Catalogs <br></li>@endif 
                     @if(@$active_menus->pressrelease==2) <li>Pressrelease <br></li>@endif
                     @if(@$active_menus->videos==2)<li> Videos <br></li> @endif 
                     @if(@$active_menus->products==2) <li>Products <br></li>@endif 
                   </ul>
                </h5>
              </div>
             </div>
             
             
             <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($companyprofile->active_flag == 1)
                    Active
                    @elseif($companyprofile->active_flag == 0)
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
                <h5>{!! date('j F Y', strtotime($companyprofile->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($companyprofile->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$companyprofile->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

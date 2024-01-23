@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Products / Show #{!!$product->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default pull-left" href="{!! route('products.index')  !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{!! route('products.edit', $product->id)  !!}">
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
                  <h5>{!! @$product->company->comp_name !!}</h5>
             </div> 
          </div>
          <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Profile Name</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! @$product->compprofile->title !!}</h5>
             </div> 
          </div>
           <div class="row">
            <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Category Name</h4>
            </div>
            <div class="col-md-9">
              @if($product->categories()->count() > 0)
              <ul>
                @foreach($product->categories as $list)
                  <li>{{ $list->name }}</li>
                @endforeach
                </ul>
              @endif
             </div> 
          </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $product->title  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="products icon"></i> Small Image</h4>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($product->small_image)
                  <img width="100" src="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->small_image;?>">
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="products icon"></i> Big Image</h4>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($product->big_image)
                  <img width="100" src="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->big_image;?>">
                  @endif
                </h5>
              </div>
             </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="products icon"></i>Tech Spec Pdf</h4>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($product->tech_spec_pdf)
                  <a target="_blank" href="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->tech_spec_pdf;?>">View pdf file</a>
                  @endif
                </h5>
              </div>
             </div>
          <div class="row">
             <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Alt Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $product->alt_tag  !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Title Tag</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $product->title_tag !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3">
              <h4 class="text-primary"><i class="company icon"></i>Description</h4>
            </div>
            <div class="col-md-9">
                  <h5>{!! $product->description !!}</h5>
             </div> 
          </div>
          <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Status</h4>
              </div>
              <div class="col-md-9">
                <h5>@if($product->active_flag == 1)
                    Active
                    @elseif($product->active_flag == 0)
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
                <h5>{!! date('j F Y', strtotime($product->created_at))  !!}<i class="time icon"></i> {!! date('g:i a', strtotime($product->created_at))  !!}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"> 
                <h4 class="text-primary"><i class="eventprofile icon"></i>Created By</h4>
              </div>
              <div class="col-md-9">
                <h5>{!! @$product->author->name !!}</h5>                
              </div>
            </div>

        </div>
    </div>

@endsection

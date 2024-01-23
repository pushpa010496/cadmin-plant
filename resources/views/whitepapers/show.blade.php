@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3> Whitepaper / Show #{!! $whitepaper->id !!}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('whitepapers.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('whitepapers.edit', $whitepaper->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! date('j F Y', strtotime($whitepaper->date))  !!}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->title  !!}</h5>
              </div>
             </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>whitepaper Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($whitepaper->image)
                  <img width="200" src="<?php echo config('app.url'); ?>whitepapers/<?php echo $whitepaper->image;?>">
                  @endif
                </h5>
              </div>
             </div>
             <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Whitepaper PDF</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($whitepaper->pdf)
                  <a href="<?php echo config('app.url'); ?>whitepapers/<?php echo $whitepaper->pdf;?>"> View PDF </a>
                  @endif
                </h5>
              </div>
             </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->img_alt  !!}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->img_title  !!}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>whitepaper Url</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->whitepapers_url  !!}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Home Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->home_title  !!}</h5>
              </div>
            </div>
            <div class="row">  
               <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Home Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->home_description  !!}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! $whitepaper->description  !!}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($whitepaper->active_flag == 1)
                    Active
                    @elseif($whitepaper->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="whitepaper icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{!! date('j F Y', strtotime($whitepaper->created_at)) !!}<i class="time icon"></i> {!! date('g:i a', strtotime($whitepaper->created_at))  !!}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

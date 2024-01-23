@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3> Reports / Show #{{$report->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('reports.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('reports.edit', $report->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        
            <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($report->date)) }}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->title }}</h5>
              </div>
             </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>reports Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($report->image)
                  <img width="200" src="<?php echo config('app.url'); ?>reports/<?php echo $report->image;?>">
                  @endif
                </h5>
              </div>
             </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->img_alt }}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->img_title }}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Location</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->location }}</h5>
              </div>
            </div>
           
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>reports Url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->reports_url }}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Home Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->home_title }}</h5>
              </div>
            </div>
            <div class="row">  
               <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Home Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->home_description }}</h5>
              </div>
               </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $report->description }}</h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($report->active_flag == 1)
                    Active
                    @elseif($report->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>
            </div>
            <div class="row">  
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="reports icon"></i> Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($report->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($report->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>ProductLaunch / Show #{{$project->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('productlaunch.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('productlaunch.edit', $project->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
           
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($project->date)) }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>project Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($project->image)
                  <img width="200" src="<?php echo config('app.url'); ?>project/<?php echo $project->image;?>">
                  @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Img alt</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->img_alt }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Img Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->img_title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Location</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->location }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Commencement</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->commencement }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Project Url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->project_url }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Home Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->home_title }}</h5>
              </div>

               <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Home Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->home_description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $project->description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($project->active_flag == 1)
                    Active
                    @elseif($project->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="project icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($project->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($project->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

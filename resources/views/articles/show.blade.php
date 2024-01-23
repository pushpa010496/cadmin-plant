@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Article / Show #{{$article->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('articles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('articles.edit', $article->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Article Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $article->article_title }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Article url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $article->article_url }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Article Image</h5>
              </div>
              <div class="col-md-9">
                <h5>
                  @if($article->article_image)
                  <img width="200" src="<?php echo config('app.url'); ?>articles/<?php echo $article->article_image;?>">
                  @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Article home title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $article->home_title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Article Small image</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($article->small_image)
                  <img width="200" src="<?php echo config('app.url'); ?>articles/<?php echo $article->small_image;?>">
                  @endif</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Short Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $article->short_description }}</h5>
              </div>


              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($article->active_flag == 1)
                    Active
                    @elseif($article->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $article->article_description }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="article icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($article->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($article->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

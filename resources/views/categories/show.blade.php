@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Category / Show #{{$category->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-link" href="{{ route('categories.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('categories.edit', $category->id) }}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

<div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
               <h5><i class="category icon"></i>Category Name</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $category->name }}</h5>
             </div>  
        </div>
        <div class="row">
            <div class="col-md-6">
               <h5><i class="category icon"></i>Category Slug</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $category->slug }}</h5>
             </div>  
        </div>
        <div class="row">
            <div class="col-md-6">
               <h5><i class="category icon"></i>Parent</h5>
            </div>
            <div class="col-md-6">
                  <h5>  {!! \App\Category::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($category->parent_id)
                   ->renderAsDropdown() !!}</h5>
             </div>  
        </div>
        <div class="row">

             <div class="col-md-6">
               <h5><i class="category icon"></i>Category Image</h5>
            </div>
            <div class="col-md-6">
               @if($category->image)  <h5> <img width="200" src="{{config('app.url')}}category/{{$category->image}}" /></h5>
               @endif
             </div>  
             </div>
        <div class="row">
        
             <div class="col-md-6">
               <h5><i class="category icon"></i>Short Description</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $category->short_description }}</h5>
             </div>  
         </div>
        
        </div>
    </div>
@endsection

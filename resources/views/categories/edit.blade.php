@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> Category / Edit #{{$category->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
         <div class="col-md-offset-3 col-md-6">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
            	<label for="name-field">Category Name</label>
            	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $category->name ) }}" />
                </div> 
                <div class="form-group">
                    {!! Form::label('parent_id', 'Parent:') !!}
                   {!! \App\Category::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected(59)
                   ->renderAsDropdown() !!}
                </div>
                <div class="form-group">
                <label for="image-field">Category Image</label>
                <input class="" type="file" name="image" id="image-field" />
                @if($category->image)
                <img width="200" src="{{config('app.url')}}category/{{$category->image}}" />
                @endif
                </div> 

                <div class="form-group">
                <label for="short_description-field">Category Description</label>
                <textarea name="short_description" class="form-control" rows="5">{{ old('short_description', $category->short_description ) }}</textarea>
                </div> 
                
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('categories.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

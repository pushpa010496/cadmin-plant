@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> subCategory / Edit #{{$subcategory->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
         <div class="col-md-offset-3 col-md-6">
            <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
            	<label for="subcat_name-field">subCategory Name</label>
            	<input class="form-control" type="text" name="subcat_name" id="subcat_name-field" value="{{ old('subcat_name', $subcategory->subcat_name ) }}" />
                </div> 

                <div class="form-group">
                <label for="subcat_img-field">subCategory Image</label>
                <input class="" type="file" name="image" id="image-field" />
                @if($subcategory->subcat_img)
                <img width="200" src="{{config('app.url')}}subcategory/{{$subcategory->subcat_img}}" />
                @endif
                </div> 
                <div class="form-group">
                    {!! Form::label('cat_id', 'Category:') !!}
                    {!! Form::select('cat_id', $categories,$subcategory->cat_id,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                <label for="subcat_des-field">subCategory Description</label>
                <textarea name="subcat_des" class="form-control" rows="5">{{ old('subcat_des', $subcategory->subcat_des ) }}</textarea>
                </div> 
                
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('subcategories.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> subsubCategory / Edit #{{$subsubcategory->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
         <div class="col-md-offset-3 col-md-6">
            <form action="{{ route('subsubcategories.update', $subsubcategory->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
            	<label for="subsubcat_name-field">subsubCategory Name</label>
            	<input class="form-control" type="text" name="subsubcat_name" id="subsubcat_name-field" value="{{ old('subsubcat_name', $subsubcategory->subsubcat_name ) }}" />
                </div> 

                <div class="form-group">
                <label for="subsubcat_img-field">subsubCategory Image</label>
                <input class="" type="file" name="image" id="image-field" />
                @if($subsubcategory->subsubcat_img)
                <img width="200" src="{{config('app.url')}}subcategory/{{$subcategory->subcat_img}}" />
                @endif
                </div> 
                <div class="form-group">
                    {!! Form::label('cat_id', 'Category:') !!}
                    {!! Form::select('cat_id', $categories,$subsubcategory->cat_id,['class'=>'form-control']) !!}
                </div>
                <div class="form-group" >
                    {!! Form::label('subcat_id', 'sub Category:') !!}
                   {!! Form::select('subcat_id', $subcategory,$subsubcategory->subcat_id,['class'=>'form-control','id'=>'subcategory']) !!}
                </div>
                <div class="form-group">
                <label for="subsubcat_des-field">subsubCategory Description</label>
                <textarea name="subsubcat_des" class="form-control" rows="5">{{ old('subsubcat_des', $subsubcategory->subsubcat_des) }}</textarea>
                </div> 
                
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('subsubcategories.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')

 <script type="text/javascript">
    $("#cat").on('change',function (e) {

        var cat_id = e.target.value;
       $.get('{{url("/")}}/ajax-cate/'+cat_id,function(data) {
            $("#subcategory").empty().append(data);      
       });
    });
</script>
@endsection

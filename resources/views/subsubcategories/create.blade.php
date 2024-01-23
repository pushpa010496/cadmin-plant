@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  sub Sub Category / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6">

                 {!! Form::open(array('route' => 'subsubcategories.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('name', 'sub Sub Category Name:') !!}
                    {{ Form::input('text', 'subsubcat_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('subsubcat_img', 'sub Sub Category Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
                 <div class="form-group">
                    {!! Form::label('cat_id', 'Category:') !!}
                    <select name="cat_id" class="form-control" required="required" id="cat">
                        <option value="0">-- Select one --</option>
                        @foreach($categories as $cate)
                        <option value="{{$cate->id}}">{{$cate->cat_name}}</option>
                        @endforeach
                    </select>
                </div>
                 <div class="form-group" >
                    {!! Form::label('subcat_id', 'sub Category:') !!}
                    <select name="subcat_id" class="form-control" required="required" id="subcategory">
                    </select>
                </div>

                <div class="form-group">
                    {!! Form::label('subsubcat_des', 'sub Sub Category Description:') !!}
                    {{ Form::textarea('subsubcat_des', null, ['class' => 'form-control','rows'=>'5']) }}
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-link pull-right" href="{{ route('subsubcategories.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
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

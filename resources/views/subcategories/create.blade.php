@extends('../layouts/app')
<?php 
    use App\subCategory;
 ?>
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Sub Category / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6">

                 {!! Form::open(array('route' => 'subcategories.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Sub Category Name:') !!}
                    {{ Form::input('text', 'subcat_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('subcat_img', 'Sub Category Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
                 <div class="form-group">
                    {!! Form::label('cat_id', 'Category:') !!}
                    <select name="cat_id" class="form-control" required="required">
                        <option value="0">-- Select one --</option>
                        @foreach($categories as $cate)
                        <option value="{{$cate->id}}">{{$cate->cat_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {!! Form::label('subcat_des', 'Sub Category Description:') !!}
                    {{ Form::textarea('subcat_des', null, ['class' => 'form-control','rows'=>'5']) }}
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-link pull-right" href="{{ route('categories.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#technology").on('change',function (e) {
        var tech_id = e.target.value;
       $.get('{{url("/")}}/ajax-cate/'+tech_id,function(data) {

            $("#category").empty().append(data);      
       });
    });
</script>
@endsection

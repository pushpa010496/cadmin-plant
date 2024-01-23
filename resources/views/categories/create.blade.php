@extends('../layouts/app')
<?php 
    use App\Category;
 ?>
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Category / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6">

                 {!! Form::open(array('route' => 'categories.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', 'Parent:') !!}
                   {!! \App\Category::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])->renderAsDropdown() !!}
                </div>
                <div class="form-group">
                    {!! Form::label('image', 'Category Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
               
                <div class="form-group">
                    {!! Form::label('short_description', 'Category Description:') !!}
                    {{ Form::textarea('short_description', null, ['class' => 'form-control','rows'=>'5']) }}
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

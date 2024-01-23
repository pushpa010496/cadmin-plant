@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Product Tags / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'subtags.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('category_id', 'Categories:') !!}
                    {{ Form::select('category_id', $category_list, null, ['class' => 'form-control','id'=>'category_id','required'=>'required','placeholder'=>'Select Category']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('tag_id', 'Tag:') !!}
                    {{ Form::select('tag_id', $tags, null, ['class' => 'form-control','id' =>'tags','required'=>'required','placeholder'=>'Select Tag']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('subtag_name', 'Subtag Name:') !!}
                    {{ Form::input('text', 'subtag_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                      
           
              <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('tags.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>  
          
               
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">

    $("#category_id").on('change',function (e) {

                var cat_id = e.target.value;
                console.log(cat_id);
             
                 $.get('{{url("/")}}/ajax-category/'+cat_id,function(data) {
                    $("#tags").empty();      
                     $("#tags").append(data);             
                 });
                

        });
    </script>
@endsection
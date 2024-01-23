@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Product Tags / Create </h3>
    </div>
    <style type="text/css">
        .error{
            font-weight:600;
            font-color:#ccc; 
            color: red;
        }
    </style>
@endsection

@section('content')
   
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">
      {!! Form::open(array('route' => 'tags.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('category_id', 'Categories:') !!}
                    {{ Form::select('category_id', $category_list, null, ['class' => 'form-control','id'=>'','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('tag_name', 'Tag name:') !!}
                    {{ Form::input('text','tag_name', null, ['class' => 'form-control','id'=>'tag_name','onkeypress'=>'myFunction();','required'=>'required']) }}
                </div>
                
            @if(session()->has('message'))
                <p class="error">
                    {{ session()->get('message') }}
                </p>
            @endif 
           
              <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary" id="test">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('tags.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>  
          
               
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
     var options = {
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("article")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Files',
    filebrowserUploadUrl: '{{public_path("article")}}/?type=Files&_token='
    };
  $('textarea.my-editor').ckeditor(options);
</script>

@endsection
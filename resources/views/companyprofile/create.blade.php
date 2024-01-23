@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Company Profile / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'companyprofile.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Profile Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null, ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
              
               <div class="form-group">
                    {!! Form::label('url', 'Profile Url:') !!}
                    {{ Form::input('text', 'url', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                               
             <div class="form-group">
                    {!! Form::label('active_menus', 'Active Menus:*') !!}<br/>
                    <input value="2" name="active_menus[whitepapers]" type="checkbox">  Whitepapers 
                    &nbsp;&nbsp;<input value="2" name="active_menus[catalogs]" type="checkbox">  Catalogs
                    &nbsp;&nbsp;<input value="2" name="active_menus[pressrelease]" type="checkbox">  Pressrelease
                    &nbsp;&nbsp;<input value="2" name="active_menus[videos]" type="checkbox">  Videos
                    <input value="2" name="active_menus[products]" type="checkbox">  Products
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
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('companyprofile.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
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
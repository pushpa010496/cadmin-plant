@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3> Company Profile / Edit #{{$companyprofile->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-3 col-md-8 col-md-offset-3">

            <form action="{{ route('companyprofile.update', $companyprofile->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

             <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, $companyprofile->company_id, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Profile Title:') !!}
                    {{ Form::input('text', 'title', $companyprofile->title, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', $companyprofile->description, ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
              
               <div class="form-group">
                    {!! Form::label('url', 'Profile Url:') !!}
                    {{ Form::input('text', 'url', $companyprofile->url, ['class' => 'form-control','required'=>'required']) }}
                </div>
                               
             <div class="form-group">
                    {!! Form::label('active_menus', 'Active Menus:*') !!}<br/>
                    <?php $active_menus = json_decode($companyprofile->active_menus); ?>
                    <input value="2" name="active_menus[whitepapers]" @if(@$active_menus->whitepapers==2) checked @endif type="checkbox">  Whitepapers
                    &nbsp;&nbsp;<input value="2" @if(@$active_menus->catalogs==2) checked @endif name="active_menus[catalogs]" type="checkbox">  Catalogs
                    &nbsp;&nbsp;<input value="2" @if(@$active_menus->pressrelease==2) checked @endif name="active_menus[pressrelease]" type="checkbox">  Pressrelease
                    &nbsp;&nbsp;<input value="2" @if(@$active_menus->videos==2) checked @endif name="active_menus[videos]" type="checkbox">  Videos
                    &nbsp;&nbsp;<input value="2" @if(@$active_menus->products==2) checked @endif name="active_menus[products]" type="checkbox">  Products
              </div>
            <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}

                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($companyprofile->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($companyprofile->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>
                               
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    
                     <a class="btn btn-sm btn-default pull-right" href="{{ route('companyprofile.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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
@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Article / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('route' => 'articles.store','files'=>true)) !!}
                
                  <!-- Auther bio -->
                <div class="form-group">
                    {!! Form::label('auther_name', 'Auther Name:') !!}
                    {{ Form::input('text', 'auther_name', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('auther_designation', 'Auther Designation:') !!}
                    {{ Form::input('text', 'auther_designation', null, ['class' => 'form-control']) }}
                </div>    
                 <div class="form-group">
                      {!! Form::label('auther_image', 'Auther Image:') !!}
                     {!! Form::file('auther_image', array('class' => '')) !!}
                </div>  
                 <div class="form-group">
                    {!! Form::label('auther_description', 'Auther Description:') !!}
                    {{ Form::textarea('auther_description', null, ['class' => 'form-control','rows'=>'4']) }}                    
                </div> 
                <!-- Auther bio end--> 
                
                <div class="form-group">
                    {!! Form::label('article_title', 'Article Title:') !!}
                    {{ Form::input('text', 'article_title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('article_url', 'Article Url:') !!}
                    {{ Form::input('text', 'article_url', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('article_image', 'Article Image:') !!}
                     {!! Form::file('article_image', array('class' => '')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('article_description', 'Article Description:') !!}
                    {{ Form::textarea('article_description', null, ['class' => 'form-control my-editor','id'=>'myEditor']) }}                    
                </div>

                <div class="form-group">
                    {!! Form::label('home_title', 'Article Home Title:') !!}
                    {{ Form::input('text', 'home_title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group"> 
                    {!! Form::label('short_description', 'Short Description:') !!}
                    {{ Form::textarea('short_description', null, ['class' => 'form-control','rows'=>3]) }}                    
                </div>
                <div class="form-group">
                    {!! Form::label('small_image', 'Small Image:') !!}
                     {!! Form::file('small_image', array('class' => '')) !!}
                </div>
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('articles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
<script>
$(document).ready(function(){

    // Define function to open filemanager window
    var lfm = function(options, cb) {
        var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };
    
    // Define LFM summernote button
    var LFMButton = function(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Insert image with filemanager',
            click: function() {
        
                lfm({type: 'image', prefix: '/file-manager'}, function(url, path) {
                    context.invoke('insertImage', url);
                });

            }
        });
        return button.render();
    };
    
    // Initialize summernote with LFM button in the popover button group
    // Please note that you can add this button to any other button group you'd like
    $('#summernote-editor').summernote({
        toolbar: [
            ['popovers', ['lfm']],
        ],
        buttons: {
            lfm: LFMButton
        }
    })
   
});
</script>
@endsection

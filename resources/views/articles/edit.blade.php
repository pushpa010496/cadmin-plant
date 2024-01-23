@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> article / Edit #{{$article->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Auther bio -->
                <div class="form-group">
                    {!! Form::label('auther_name', 'Auther Name:') !!}
                    {{ Form::input('text', 'auther_name', old('auther_name', $article->auther_name ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('auther_designation', 'Auther Designation:') !!}
                    {{ Form::input('text', 'auther_designation', old('auther_designation', $article->auther_designation ), ['class' => 'form-control']) }}
                </div>    
                 <div class="form-group">
                      {!! Form::label('auther_image', 'Auther Image:') !!}
                     {!! Form::file('auther_image', array('class' => '')) !!}

                       @if($article->auther_image)
                    <img width="200" src="<?php echo config('app.url'); ?>articles/<?php echo $article->auther_image;?>">
                    @endif
                </div>  
                 <div class="form-group">
                    {!! Form::label('auther_description', 'Auther Description:') !!}
                    {{ Form::textarea('auther_description', old('auther_description', $article->auther_description ), ['class' => 'form-control','rows'=>'4']) }}                    
                </div> 
                <!-- Auther bio end-->
                <div class="form-group">
                    {!! Form::label('article_title', 'Article Title:') !!}
                    {{ Form::input('text', 'article_title', old('article_title', $article->article_title ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('article_url', 'Article Url:') !!}
                    {{ Form::input('text', 'article_url', old('article_url', $article->article_url ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('article_image', 'Article Image:') !!}
                     {!! Form::file('article_image', array('class' => '')) !!}
                     @if($article->article_image)
                    <img width="200" src="<?php echo config('app.url'); ?>articles/<?php echo $article->article_image;?>">
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('article_description', 'Article Description:') !!}
                    {{ Form::textarea('article_description', old('article_description', $article->article_description ), ['class' => 'form-control my-editor','rows'=>3]) }}                    
                </div>

                <div class="form-group">
                    {!! Form::label('home_title', 'Article Home Title:') !!}
                    {{ Form::input('text', 'home_title', old('home_title', $article->home_title ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('short_description', 'Short Description:') !!}
                    {{ Form::textarea('short_description', old('short_description', $article->short_description ), ['class' => 'form-control','rows'=>3]) }}                    
                </div>
                <div class="form-group">
                    {!! Form::label('small_image', 'Small Image:') !!}
                     {!! Form::file('small_image', array('class' => '')) !!}
                     @if($article->small_image)
                       <img width="200" src="<?php echo config('app.url'); ?>articles/<?php echo $article->small_image;?>">
                     @endif
                </div>
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($article->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($article->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('articles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')

<script>
     var options = {
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>interview/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("interview")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>interview/?type=Files',
    filebrowserUploadUrl: '{{public_path("interview")}}/?type=Files&_token='
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

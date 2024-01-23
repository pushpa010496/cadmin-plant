@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> interview / Edit #{{$interview->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('interviews.update', $interview->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', old('name', $interview->name ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('interviews_url', 'Interviews Url:') !!}
                    {{ Form::input('text', 'interviews_url', old('interviews_url', $interview->interviews_url ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'Interview Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                       @if($interview->image)
                       <img width="100" src="<?php echo config('app.url'); ?>interview/<?php echo $interview->image;?>">
                     @endif
                </div>
                <!--  <div class="form-group">

                    {!! Form::label('position_check', 'Home Position:') !!}
                    @if($interview->position_status == 'on')
                    <input type="checkbox" name="position_check" checked="checked">
                    @else
                    <input type="checkbox" name="position_check">
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('home_position', 'Home Position:') !!}
                    {{ Form::input('text', 'home_position', old('home_position', $interview->home_position ), ['class' => 'form-control']) }}
                </div> -->
                <div class="form-group">
                    {!! Form::label('img_destination_url', 'Interview Destination Url:') !!}
                    {{ Form::input('text', 'img_destination_url', old('img_destination_url', $interview->img_destination_url ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Interview Alt:') !!}
                    {{ Form::input('text', 'img_alt',  old('img_alt', $interview->img_alt ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Interview Title:') !!}
                    {{ Form::input('text', 'title', old('title', $interview->title ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company', 'Company:') !!}
                    {{ Form::input('text', 'company', old('company', $interview->company ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('designation', 'Designation:') !!}
                    {{ Form::input('text', 'designation', old('designation', $interview->designation ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group"> 
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description', $interview->description ), ['class' => 'form-control','rows'=>3]) }}                    
                </div>
                <div class="form-group">
                    {!! Form::label('add_questions', 'Add Questions:') !!}
                    {{ Form::textarea('add_questions',  old('add_questions', $interview->add_questions ), ['class' => 'form-control my-editor','id'=>'myEditor']) }}                    
                </div>
                <div class="form-group">
                    {!! Form::label('small_image', 'Small Image:') !!}
                     {!! Form::file('small_image', array('class' => '')) !!}
                     @if($interview->small_image)
                       <img width="200" src="<?php echo config('app.url'); ?>interview/<?php echo $interview->small_image;?>">
                     @endif
                </div>
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($interview->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($interview->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('interviews.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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

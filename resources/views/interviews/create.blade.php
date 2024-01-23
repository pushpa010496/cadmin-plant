@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Interview / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('route' => 'interviews.store','files'=>true)) !!}
                
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('interviews_url', 'Interviews Url:') !!}
                    {{ Form::input('text', 'interviews_url', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'Interview Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('img_destination_url', 'Interview Destination Url:') !!}
                    {{ Form::input('text', 'img_destination_url', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Interview Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>
                <!--  <div class="form-group">
                    {!! Form::label('position_check', 'Home Position:') !!}
                    {{ Form::input('checkbox', 'position_check',null,['id' => 'position_check']) }}
                </div>
                <div class="form-group" id="home_pos">
                    {!! Form::label('home_position', 'Home Position:') !!}
                    {{ Form::input('text', 'home_position', null, ['class' => 'form-control']) }}
                </div> -->
                <div class="form-group">
                    {!! Form::label('title', 'Interview Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company', 'Company:') !!}
                    {{ Form::input('text', 'company', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('designation', 'Designation:') !!}
                    {{ Form::input('text', 'designation', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group"> 
                    {!! Form::label('description', 'Author Bio:') !!}
                    {{ Form::textarea('description', null, ['class' => 'form-control','rows'=>3]) }}                    
                </div>
                <div class="form-group">
                    {!! Form::label('add_questions', 'Add Questions:') !!}
                    {{ Form::textarea('add_questions', null, ['class' => 'form-control my-editor','id'=>'myEditor']) }}                    
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
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('interviews.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
    /*$('#home_pos').hide();


  $("#position_check").on("click",function() {
    $("#home_pos").toggle(this.checked);
  });
*/

    

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

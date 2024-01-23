@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Testimonials / Edit #{{$testimonial->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                 <div class="form-group">
                    {!! Form::label('client_name', 'Client Name:') !!}
                    {{ Form::input('text', 'client_name', old('client_name',$testimonial->client_name), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_name', 'Company Name:') !!}
                    {{ Form::input('text', 'company_name', old('company_name',$testimonial->company_name), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'Testimonial Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                     @if($testimonial->image)
                       <img width="200" src="<?php echo config('app.url'); ?>testimonial/<?php echo $testimonial->image;?>">
                     @endif
                </div>
            
                <div class="form-group">
                    {!! Form::label('img_title', 'testimonial Img Title:') !!}
                    {{ Form::input('text', 'img_title', old('img_title',$testimonial->img_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'testimonial Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', old('img_alt',$testimonial->img_alt), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('designation', 'Designation:') !!}
                    {{ Form::input('text', 'designation', old('designation',$testimonial->designation), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$testimonial->description), ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('adv_description', 'Adv Description:') !!}
                    {{ Form::textarea('adv_description', old('adv_description',$testimonial->adv_description), ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($testimonial->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($testimonial->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('testimonials.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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

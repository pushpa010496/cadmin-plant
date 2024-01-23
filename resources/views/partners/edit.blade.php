@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Partner / Edit #{{$partner->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                 <div class="form-group">
                    {!! Form::label('type', 'Type:') !!}                    
                    <select name="type" class="form-control">
                        <option value="">Select</option>
                        <option value="1">Online Partners</option>
                        <option value="2" selected="selected">Media Partners</option>
                        <option value="3">Group Partners</option>
                        <option value="4">Association Partners</option>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'partner Title:') !!}
                    {{ Form::input('text', 'title', old('title', $partner->title ), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('partner_url', 'partner Url:') !!}
                    {{ Form::input('text', 'partner_url', old('partner_url', $partner->partner_url ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('partner_url_active', 'Active Profile Redirect:') !!}
                    
                    <input type="radio" id="smt-fld-1-2" name="optradio1" value="1" {{ $partner->url_active == '1' ? 'checked' : ''}}>Yes</label>
                  
                    <input type="radio" id="smt-fld-1-3" name="optradio1" value="0" {{ $partner->url_active == '0' ? 'checked' : ''}}>No</label>
                    
                </div>
                 <div class="form-group">
                    {!! Form::label('partner_image', 'partner Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                      @if($partner->image)
                       <img width="200" src="<?php echo config('app.url'); ?>partner/<?php echo $partner->image;?>">
                     @endif
                </div>
            
                <div class="form-group">
                    {!! Form::label('img_title', 'Partner Img Title:') !!}
                    {{ Form::input('text', 'img_title', old('img_title', $partner->img_title ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Partner Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', old('img_alt', $partner->img_alt ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('home_logo', 'Home Image:') !!}
                     {!! Form::file('home_logo', array('class' => '')) !!}
                     @if($partner->home_logo)
                       <img width="200" src="<?php echo config('app.url'); ?>partner/<?php echo $partner->home_logo;?>">
                     @endif
                </div>
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($partner->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($partner->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('partners.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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

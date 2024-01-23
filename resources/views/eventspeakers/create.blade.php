@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Event Speakers / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                 {!! Form::open(array('route' => 'eventspeakers.store','files'=>true)) !!}
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('event_id', 'Event:') !!}
                    {{ Form::select('event_id', $eventlist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                
                <div class="form-group">
                    {!! Form::label('image', 'Image :') !!}
                    {{ Form::file('image', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_title', 'Img Title:') !!}
                    {{ Form::input('text', 'img_title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>               
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('designation', 'Designation:') !!}
                    {{ Form::input('text', 'designation', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('type', 'Type:') !!}
                    <select name="type" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                            <option value="0">Other</option>
                            <option value="1">PCD Conference Speaker</option>
                            <option value="2">ADF Conference Speaker</option>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('shown_on_profile', 'Show on Profile:') !!}
                      &nbsp;&nbsp;  {{ Form::input('radio', 'shown_on_profile', 1) }}Yes
                       &nbsp;&nbsp; {{ Form::input('radio', 'shown_on_profile', 0) }}No  
                </div>
               
                 <div class="form-group">
                    {!! Form::label('speaker_profile_img', 'Speaker Profile Image:') !!}
                     {!! Form::file('speaker_profile_img', array('class' => '')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>                 
                <div>&nbsp;</div>
                <div>&nbsp;</div>
            </div>
                 
                <div class="well well-sm">
                    <a class="btn btn-sm btn-default" href="{{ route('eventspeakers.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                    <button type="submit" class="btn btn-sm btn-primary pull-right">Create</button>
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
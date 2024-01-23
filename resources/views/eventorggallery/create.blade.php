@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Event Organiser Gallery / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                 {!! Form::open(array('route' => 'eventorggallery.store','files'=>true)) !!}
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('event_org_id', 'Event:') !!}
                    {{ Form::select('event_org_id', $eventlist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                
                <div class="form-group">
                    {!! Form::label('small_img', 'Small Img :') !!}
                    {{ Form::file('small_img', null, ['class' => 'form-control']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('big_img', 'Big Image:') !!}
                     {!! Form::file('big_img', array('class' => '')) !!}
                </div>
               
            </div>
            <div class="col-md-6">
                
                <div class="form-group">
                    {!! Form::label('img_title', 'Img Title:') !!}
                    {{ Form::input('text', 'img_title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                 
            </div>
                
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('eventorggallery.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
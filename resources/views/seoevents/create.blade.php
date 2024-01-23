@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  SEO Event / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">
                    <?php $value = ''; ?> 
                 {!! Form::open(array('route' => 'seoevents.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('event_id', 'Event:') !!}
                    {{ Form::select('event_id', $eventlist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('pages', 'Pages:') !!}
                    {{ Form::select('pages', 
                    ['event_profile'=>'Profile',
                      'gallery'=>'Gallery',
                      'pressrelease'=> 'Pressrealese',
                      'speakers'=>'Speaker',
                      'brochures'=>'Brochure','partners'=>'Partners','exhibitors'=>'Exhibitors'], null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Page']) }}
                </div>
                 @includeIf('./seoform')
               
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
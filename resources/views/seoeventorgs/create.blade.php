@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  SEO Company / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">
                    <?php $value = ''; ?> 
                 {!! Form::open(array('route' => 'seoeventorg.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('seo_event_org_id', 'Event Organizers:') !!}
                    {{ Form::select('seo_event_org_id', $eventorgs, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Seo Event Organizer']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('pages', 'Pages:') !!}
                    {{ Form::select('pages', 
                    ['about'=>'about',
                    'brouchers'=>'brochures',
                      'presreleases'=>'pressreleases',
                      'interviews'=> 'interviews',
                      'articles'=>'articles',
                      'gallery'=>'gallery'], null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Page']) }}
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
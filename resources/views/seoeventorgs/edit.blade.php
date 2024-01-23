@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3>SEO Company  / Edit #{{$value->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-3 col-md-8 col-md-offset-3">

            <form action="{{ route('seoeventorg.update', $value->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('seo_event_org_id', 'Company Profile:') !!}
                    {{ Form::select('seo_event_org_id', $evntorglist, $value->event_org_id, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('pages', 'Pages:') !!}
                    {{ Form::select('pages', 
                    ['brouchers'=>'brochures',
                    'about'=>'about',
                      'presreleases'=>'pressreleases',
                      'interviews'=> 'interviews',
                      'articles'=>'articles',
                      'gallery'=>'gallery'], $value->pages, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Page']) }}
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
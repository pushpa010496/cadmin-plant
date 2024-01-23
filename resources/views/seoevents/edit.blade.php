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

            <form action="{{ route('seoevents.update', $value->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('event_id', 'Event:') !!}
                    {{ Form::select('event_id', $eventlist, $value->event_id, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('pages', 'Pages:') !!}
                    {{ Form::select('pages', 
                    ['event_profile'=>'Profile',
                      'gallery'=>'Gallery',
                      'pressrelease'=> 'Pressrealese',
                      'speakers'=>'Speaker',
                      'brochures'=>'Brochure','partners'=>'Partners','exhibitors'=>'Exhibitors'], $value->pages, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Page']) }}
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
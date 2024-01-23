@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Whitepapers / Edit #{{$whitepaper->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('whitepapers.update', $whitepaper->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('date', 'Date:') !!}
                    {{ Form::input('text', 'date', old('date',$whitepaper->date), ['class' => 'form-control','required'=>'required','id'=>'datepicker']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', old('title',$whitepaper->title), ['class' => 'form-control','required'=>'required']) }}
                </div>
               
                 <div class="form-group">
                    {!! Form::label('image', 'Whitepapers Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                     @if($whitepaper->image)
                       <img width="200" src="<?php echo config('app.url'); ?>whitepapers/<?php echo $whitepaper->image;?>">
                     @endif
                </div>
                <div class="form-group">
                    {!! Form::label('pdf', 'Pdf:') !!}
                    {!! Form::file('pdf', array('class' => '')) !!}
                     @if($whitepaper->pdf)
                      <a href="<?php echo config('app.url'); ?>whitepapers/<?php echo $whitepaper->pdf;?>"> View PDF</a>
                     @endif
                </div>
                <div class="form-group">
                    {!! Form::label('img_title', 'Whitepapers Img Title:') !!}
                    {{ Form::input('text', 'img_title', old('img_title',$whitepaper->img_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Whitepapers Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', old('img_alt',$whitepaper->img_alt), ['class' => 'form-control']) }}
                </div>
                

                <div class="form-group">
                    {!! Form::label('whitepapers_url', 'Whitepapers Url:') !!}
                    {{ Form::input('text', 'whitepapers_url', old('whitepapers_url',$whitepaper->whitepapers_url), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$whitepaper->description), ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('home_title', 'Home Title:') !!}
                    {{ Form::input('text', 'home_title', old('home_title',$whitepaper->home_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('home_description', 'Home Description:') !!}
                    {{ Form::textarea('home_description', old('home_description',$whitepaper->home_description), ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($whitepaper->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($whitepaper->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('whitepapers.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>
   $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
  } );
  </script>
<script>
     var options = {
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>interview/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("interview")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>interview/?type=Files',
    filebrowserUploadUrl: '{{public_path("interview")}}/?type=Files&_token='
  };
 $('textarea.my-editor').ckeditor(options);
</script>

@endsection

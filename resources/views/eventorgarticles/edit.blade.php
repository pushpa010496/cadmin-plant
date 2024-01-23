@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Event Organiser Articles / Edit #{{$eventorgarticles->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">

            <form action="{{ route('eventorgarticles.update', $eventorgarticles->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

               <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('event_org_id', 'Event:') !!}
                    {{ Form::select('event_org_id', $eventlist,  old('event_org_id',$eventorgarticles->event_org_id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name',  old('name',$eventorgarticles->name), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('image', 'Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                      @if($eventorgarticles->image)
                       <img width="100" src="<?php echo config('app.url'); ?>event/organiser/article/<?php echo $eventorgarticles->image;?>">
                     @endif
                </div>
                 <div class="form-group">
                    {!! Form::label('img_title', 'Img Title:') !!}
                    {{ Form::input('text', 'img_title',  old('img_title',$eventorgarticles->img_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Img Alt:') !!}
                    {{ Form::input('text', 'img_alt',  old('img_alt',$eventorgarticles->img_alt), ['class' => 'form-control']) }}
                </div>
               

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('pdf', 'PDF:') !!}
                     {!! Form::file('pdf', array('class' => '')) !!}
                      @if($eventorgarticles->pdf)
                      <a href="<?php echo config('app.url'); ?>event/organiser/article/<?php echo $eventorgarticles->pdf;?>">View PDF</a>
                     @endif
                </div>
               <div class="form-group">
                    {!! Form::label('description', 'Description :') !!}
                    {{ Form::textarea('description', old('description',$eventorgarticles->description), ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>  
                
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($eventorgarticles->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($eventorgarticles->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>
            </div>

                <div class="well well-sm">
                    <a class="btn btn-sm btn-default" href="{{ route('eventorgarticles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                    <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
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
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+0w",
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
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
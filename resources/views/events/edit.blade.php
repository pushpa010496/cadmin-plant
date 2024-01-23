@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Events / Edit #{{$event->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">

            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="col-md-6">
                  <div class="form-group">
                    {!! Form::label('event_org_id', 'Event Org:') !!}
                    {{ Form::select('event_org_id', $eventlist,  old('event_org_id',$event->event_org_id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', 'Category:') !!}
                   {!! \App\EventCategory::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($event->cat_id)
                   ->renderAsDropdown() !!}
                </div>
                <div class="form-group">
                    {!! Form::label('start_date', 'Start Date:') !!}
                    {{ Form::input('text', 'start_date', old('start_date',$event->start_date), ['class' => 'form-control','required'=>'required','id'=>'from']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('end_date', 'End Date:') !!}
                    {{ Form::input('text', 'end_date', old('end_date',$event->end_date), ['class' => 'form-control','required'=>'required','id'=>'to']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', old('name',$event->name), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('venue', 'Venue:') !!}
                    {{ Form::input('text', 'venue', old('venue',$event->venue), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Address:') !!}
                    {{ Form::input('text', 'address', old('address',$event->address), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('organiser', 'Organiser:') !!}
                    {{ Form::input('text', 'organiser', old('organiser',$event->organiser), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('country', 'Country:') !!}
                    {{ Form::input('text', 'country', old('country',$event->country), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('org_name', 'Organiser Name:') !!}
                    {{ Form::input('text', 'org_name', old('org_name',$event->org_name), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('phone', 'Phone:') !!}
                    {{ Form::input('text', ' phone', old('phone',$event->phone), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('text', 'email', old('email',$event->email), ['class' => 'form-control','required'=>'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                
                 <div class="form-group">
                    {!! Form::label('web_link', 'Web Link:') !!}
                    {{ Form::input('text', 'web_link', old('web_link',$event->web_link), ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('link_status', 'Link Active ?:*') !!}
                      @if($event->link_status == 1)
                    {{ Form::input('radio', 'link_status', 1, ['class' => '','checked'=>'checked']) }}Yes
                    {{ Form::input('radio', 'link_status', 0, ['class' => '']) }}No
                    @else
                     {{ Form::input('radio', 'link_status', 1, ['class' => '']) }}Yes
                    {{ Form::input('radio', 'link_status', 0, ['class' => '','checked'=>'checked']) }}No
                    @endif
                </div>
                 <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$event->description), ['class' => 'form-control my-editor','size'=>'30x3']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'event Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                     @if($event->image)
                       <img width="100" src="<?php echo config('app.url'); ?>event/<?php echo $event->image;?>">
                     @endif
                </div>
                <div class="form-group">
                  {{Form::label('big_image','Big Image')}}
                  {{Form::file('big_image',array('class' =>''))}}
                  @if($event->big_image)
                  <img width="100" src="<?php echo config('app.url');?>event/<?php echo $event->big_image;?>">
                  @endif
                </div>
            
                <div class="form-group">
                    {!! Form::label('img_title', 'event Img Title:') !!}
                    {{ Form::input('text', 'img_title', old('img_title',$event->img_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'event Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', old('img_alt',$event->img_alt), ['class' => 'form-control']) }}
                </div>
               
                 <div class="form-group">
                    {!! Form::label('event_type', 'Type ?:*') !!}
                     @if($event->event_type == 1)
                    {{ Form::input('radio', 'event_type', 1, ['class' => '','checked'=>'checked']) }} Event Profile      
                    {{ Form::input('radio', 'event_type', 0, ['class' => '']) }}Free Listing 
                    @else
                    {{ Form::input('radio', 'event_type', 1, ['class' => '']) }} Event Profile      
                    {{ Form::input('radio', 'event_type', 0, ['class' => '','checked'=>'checked']) }}Free Listing 
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label('event_url', 'Event Url:') !!}
                    {{ Form::input('text', 'event_url', old('event_url',$event->event_url), ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('home_title', 'Home Title:') !!}
                    {{ Form::input('text', 'home_title', old('home_title',$event->home_title), ['class' => 'form-control']) }}
                </div>
                          
                <div class="form-group">
                    {!! Form::label('status', 'Status:') !!}

                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($event->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($event->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>
                 
            </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('events.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+0w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
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
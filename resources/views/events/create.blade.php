@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Events / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                 {!! Form::open(array('route' => 'events.store','files'=>true)) !!}
            <div class="col-md-6">
               <div class="form-group">
                    {!! Form::label('event_org_id', 'Event Org:') !!}
                    {{ Form::select('event_org_id', $eventlist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Event']) }}
                </div>
            <div class="form-group">
                    {!! Form::label('parent_id', 'Category:') !!}
                   {!! \App\EventCategory::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->renderAsDropdown() !!}
                </div> 
                <div class="form-group">
                    {!! Form::label('start_date', 'Start Date:') !!}
                    {{ Form::input('text', 'start_date', null, ['class' => 'form-control','required'=>'required','id'=>'from']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('end_date', 'End Date:') !!}
                    {{ Form::input('text', 'end_date', null, ['class' => 'form-control','required'=>'required','id'=>'to']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('venue', 'Venue:') !!}
                    {{ Form::input('text', 'venue', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Address:') !!}
                    {{ Form::input('text', 'address', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('organiser', 'Organiser:') !!}
                    {{ Form::input('text', 'organiser', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('country', 'Country:') !!}
                    {{ Form::input('text', 'country', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('org_name', 'Organiser Name:') !!}
                    {{ Form::input('text', 'org_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('phone', 'Phone:') !!}
                    {{ Form::input('text', ' phone', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('text', 'email', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('password', 'Password:') !!}
                    {{ Form::input('password', 'password', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                
                 <div class="form-group">
                    {!! Form::label('web_link', 'Web Link:') !!}
                    {{ Form::input('text', 'web_link', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('link_status', 'Link Active ?:*') !!}
                    {{ Form::input('radio', 'link_status', 1, ['class' => '']) }}Yes
                    {{ Form::input('radio', 'link_status', 0, ['class' => '']) }}No
                </div>
                 <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null, ['class' => 'form-control my-editor','size'=>'30x6']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'Event Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
                <div class="form-group">
                  {{Form::label('image','Big Image:')}}
                  {{Form::file('big_image', array('class' => ''))}}
                  
                </div>
                <div class="form-group">
                    {!! Form::label('img_title', 'Event Img Title:') !!}
                    {{ Form::input('text', 'img_title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Event Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>
               
                 <div class="form-group">
                    {!! Form::label('event_type', 'Type ?:*') !!}
                    {{ Form::input('radio', 'event_type', 1, ['class' => '']) }} Event Profile      
                    {{ Form::input('radio', 'event_type', 0, ['class' => '']) }}Free Listing 
                </div>

                <div class="form-group">
                    {!! Form::label('event_url', 'Event Url:') !!}
                    {{ Form::input('text', 'event_url', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('home_title', 'Home Title:') !!}
                    {{ Form::input('text', 'home_title', null, ['class' => 'form-control']) }}
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
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('events.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("article")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Files',
    filebrowserUploadUrl: '{{public_path("article")}}/?type=Files&_token='
  };
 $('textarea.my-editor').ckeditor(options);
</script>
@endsection
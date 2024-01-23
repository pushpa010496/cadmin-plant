@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Company / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-2 col-md-10">

                 {!! Form::open(array('route' => 'companies.store','files'=>true)) !!}
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="row">

           <div class="col-md-5">
                {{Form::input('hidden','company_create',null)}}    
                <div class="form-group">
                    {!! Form::label('name', 'Company Name:') !!}
                    {{ Form::input('text', 'comp_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('name', 'Contact Person Name:') !!}
                    {{ Form::input('text', 'contact_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('comp_img', 'Company logo:') !!}
                     {!! Form::file('comp_logo', array('class' => '','required'=>'required')) !!}
                </div>
                  <div class="form-group">
                    {!! Form::label('banner_url', 'Banner URL:') !!}
                     {!! Form::input('text','banner_url', null, array('class' => 'form-control')) !!}
                </div>
               <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('email', 'email', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                     {!! Form::label( 'Other Emails for Enquiry: separete emails with comma (,)') !!}
                      {{ Form::input('text', 'email1', null, ['class' => 'form-control']) }}
                  </div>


                <div class="form-group">
                    {!! Form::label('password', 'Password:') !!}
                    {{ Form::input('text', 'password', 123456, ['class' => 'form-control','required'=>'required','disabled' => 'true']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('name', 'Phone:') !!}
                    {{ Form::input('text', 'phone', null, ['class' => 'form-control']) }}
                </div>

                   <div class="form-group">
                    {!! Form::label('fax', 'Fax:') !!}
                     {!! Form::input('text','fax', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('package', 'Package:') !!}
                    {!! Form::input('text','package', null, array('class' => 'form-control')) !!}
                </div>  
                 <div class="form-group">
                  <select name="services[]" class="form-control" required="required" multiple='multiple'>
                      <option value="">-- Select one --</option>
                      <option value="banner">Banner Advertising</option>
                      <option value="email">Email Direct marketing</option>
                      <option value="e-newsletters">E-newsletters</option>
                      <option value="profile-listing">Profile listing</option>
                      <option value="seo">Seo/Smm</option>
                    </select>   
                </div>

                <div class="form-group">
                  {!! Form::label('linkedin', 'Linkedin URL:') !!}
                  {!! Form::input('text','linkedin', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('profile_type', 'Profile Type:') !!}
                  <select name="profile_type" class="form-control" required="required">
                    <option value="">-- Select Profile type --</option>
                    <option value="blind">Blind</option>
                    <option value="free">Free</option>
                    <option value="paid">Paid</option>
                    <option value="FP">Featured Profile</option>
                  </select>
                </div>           
            </div>
            <div class="col-md-5">    
                <div class="form-group">
                    {!! Form::label('start_date', 'Start Date:') !!}
                    {{ Form::input('text', 'start_date', null, ['class' => 'form-control','id'=>'from','required'=>'required']) }}
                  
                </div>
                 <div class="form-group">                  
                    {!! Form::label('end_date', 'End Date:') !!}
                    {{ Form::input('text', 'end_date', null, ['class' => 'form-control','id'=>'to','required'=>'required']) }}
                </div>

                <div class="form-group">
                  {!! Form::label('banner_image', 'Company banner image:') !!}
                  {!! Form::file('banner_image', array('class' => '')) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('country', 'Country:') !!}
                     {!! Form::input('text','country', null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Website', 'Website:') !!}
                     {!! Form::input('text','website', null, array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                    {!! Form::label('product_url', 'Products URL:') !!}
                     {!! Form::input('text','product_url', null, array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('facebook', 'Facebook URL:') !!}
                  {!! Form::input('text','facebook', null, array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('twitter', 'Twitter URL:') !!}
                  {!! Form::input('text','twitter', null, array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('Youtube', 'Youtube URL:') !!}
                  {!! Form::input('text','youtube', null, array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('Instagram ', 'Instagram  URL:') !!}
                  {!! Form::input('text','instagram ', null, array('class' => 'form-control')) !!}
                </div>
             
              <div class="form-group">
                  {!! Form::label('active_flag', 'services:') !!}
                  <select name="services" class="form-control" required="required">
                    <option value="">-- Select one --</option>
                    <option value="banner">Banner Advertising</option>
                    <option value="email">Email Direct marketing</option>
                    <option value="e-newsletters">E-newsletters</option>
                    <option value="profile-listing">Profile listing</option>
                    <option value="seo">Seo/Smm</option>
                  </select>
                </div>         
                
            </div>
             <div class="col-md-10">    
                <!-- <div class="form-group">
                    {!! Form::label('address', 'Address:') !!}
                    {{ Form::textarea('address', null, ['class' => 'form-control','rows'=>'3']) }}

                </div> -->
                <div class="form-group">
                    {!! Form::label('address', 'Address :') !!}
                    {{ Form::textarea('address', null, ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
              </div>
           </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-link pull-right" href="{{ route('companies.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
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
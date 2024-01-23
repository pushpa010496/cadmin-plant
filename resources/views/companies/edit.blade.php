@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> company / Edit #{{$company->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-2 col-md-10">
           <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#company">Company Details</a></li>
              <li><a data-toggle="tab" href="#contact_pers">Contact Person Details</a></li>
              <li><a data-toggle="tab" href="#billing">Billing Details</a></li>
          </ul>
           <div class="tab-content">
             <div class="row tab-pane fade in active" id="company">
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="form_type" value="company">

               <div class="row">

           <div class="col-md-5">    
                <div class="form-group">
                    {!! Form::label('name', 'Company Name:') !!}
                    {{ Form::input('text', 'comp_name', old('comp_name', $company->comp_name), ['class' => 'form-control']) }}
                </div>
               {{--  <div class="form-group">
                    {!! Form::label('name', 'Contact Person Name:') !!}
                    {{ Form::input('text', 'contact_name', old('contact_name', $company->contact_name), ['class' => 'form-control']) }}
                </div> --}}
               
               <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('email', 'email', old('email', $company->email), ['class' => 'form-control']) }}
                </div>
              {{--    <div class="form-group">
                     {!! Form::label( 'Other Emails for Enquiry: separete emails with comma (,)') !!}

                      {{ Form::input('text', 'email1', old('email', $company->email1), ['class' => 'form-control']) }}
                  </div> --}}

                 <div class="form-group">
                    {!! Form::label('name', 'Phone:') !!}
                    {{ Form::input('text', 'phone', old('phone', $company->phone), ['class' => 'form-control']) }}
                </div>
                   <div class="form-group">
                    {!! Form::label('country', 'Fax:') !!}
                     {!! Form::input('text','fax', old('fax', $company->fax), array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('linkedin', 'Linkedin URL:') !!}
                  {!! Form::input('text','linkedin', old('linkedin', $company->linkedin), array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                    {!! Form::label('comp_img', 'Company logo:') !!}
                     {!! Form::file('comp_logo', array('class' => '')) !!}
                      @if($company->comp_logo)
                <img width="200" src="{{config('app.url')}}suppliers/{{str_slug($company->comp_name)}}/{{$company->comp_logo}}" />
                @endif
                </div>
                   <div class="form-group  {{ $errors->first('package', 'has-error')}}">
                    {!! Form::label('package', 'Package:') !!}
                     {!! Form::input('text','package', old('package', $company->package), array('class' => 'form-control')) !!}
                  
                    <span class="help-block">{{ $errors->first('package', ':message') }}</span>     
                  </div>

                   <div class="form-group  {{ $errors->first('services', 'has-error')}}">
                    {!! Form::label('services', 'Services:') !!}
                    {{ Form::select('services[]', ['banner'=>'Banner Advertising','email'=>'Email Direct marketing','e-newsletters'=>'E-newsletters','profile-listing'=>'Profile listing','seo'=>'Seo/Smm'], @explode(",", $company->services),['multiple'=>'multiple','class' => 'form-control','placeholder'=>'-- select Service-- ']) }}
                    <span class="help-block">{{ $errors->first('services', ':message') }}</span>     
                  </div>
                <div class="">
                  <div class="form-group  {{ $errors->first('profile_type', 'has-error')}}">
                    {!! Form::label('profile_type', 'Profile Type:') !!}
                    {{ Form::select('profile_type', ['blind'=>'Blind','free'=>'Free','paid'=>'paid','pclaim'=>'profileclaim','FP'=>'Featured Profile' ], $company->profile_type, ['class' => 'form-control','placeholder'=>'-- select Profile type-- ']) }}
                    <span class="help-block">{{ $errors->first('profile_type', ':message') }}</span>     
                  </div>
                </div>

            </div>
            <div class="col-md-5">    
                <div class="form-group">
                    {!! Form::label('start_date', 'Start Date:') !!}
                    {{ Form::input('text', 'start_date', old('start_date', $company->start_date), ['class' => 'form-control','id'=>'from']) }}                   
                </div>

                  <div class="form-group">                 
                    {!! Form::label('end_date', 'End Date:') !!}
                    {{ Form::input('text', 'end_date', old('end_date', $company->end_date), ['class' => 'form-control','id'=>'to']) }}
                </div>

            
                
                <div class="form-group">
                    {!! Form::label('country', 'Country:') !!}
                     {!! Form::input('text','country', old('country', $company->country), array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('country', 'Website:') !!}
                     {!! Form::input('text','website', old('website', $company->website), array('class' => 'form-control')) !!}
                </div>
             


                 <div class="form-group">
                    {!! Form::label('product_url', 'Products URL:') !!}
                     {!! Form::input('text','product_url',  old('product_url', $company->product_url), array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('facebook', 'Facebook URL:') !!}
                  {!! Form::input('text','facebook',  old('facebook', $company->facebook), array('class' => 'form-control')) !!}
                </div>

                 <div class="form-group">
                  {!! Form::label('twitter', 'Twitter URL:') !!}
                  {!! Form::input('text','twitter',  old('twitter', $company->twitter), array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('Youtube', 'Youtube URL:') !!}
                  {!! Form::input('text','youtube',  old('youtube', $company->youtube), array('class' => 'form-control')) !!}
                </div>

                  <div class="form-group">
                  {!! Form::label('Instagram', 'Instagram URL:') !!}
                  {!! Form::input('text','instagram',  old('instagram', $company->instagram), array('class' => 'form-control')) !!}
                </div>
                

                   <div class="form-group">
                    {!! Form::label('banner_image', 'Company banner image:') !!}
                     {!! Form::file('banner_image', array('class' => '')) !!}
                      @if($company->banner_image)
                <img width="200" src="{{config('app.url')}}suppliers/{{str_slug($company->comp_name)}}/{{$company->banner_image}}" />
                @endif
                </div>

                 <div class="form-group">
                    {!! Form::label('banner_url', 'Banner URL:') !!}
                     {!! Form::input('text','banner_url', old('banner_url', $company->banner_url), array('class' => 'form-control')) !!}
                </div>
             

                <div class="">
                  <div class="form-group  {{ $errors->first('active_flag', 'has-error')}}">
                    {!! Form::label('active_flag', 'Status:') !!}
                    {{ Form::select('active_flag', ['1'=>'Active','0'=>'In Active'], $company->active_flag, ['class' => 'form-control','placeholder'=>'-- select -- ']) }}
                    <span class="help-block">{{ $errors->first('active_flag', ':message') }}</span>     
                  </div>
                </div>


                 

                
            </div>
             <div class="col-md-10">    
               <!--  <div class="form-group">
                    {!! Form::label('address', 'Address:') !!}
                    {{ Form::textarea('address', old('address', $company->address), ['class' => 'form-control','rows'=>'3']) }}
                </div> -->
                <div class="form-group">
                    {!! Form::label('address', 'Address :') !!}
                    {{ Form::textarea('address', old('address',$company->address), ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
              </div>
           </div>
                               
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary" name="company">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('companies.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
          </div>
          <div class="row tab-pane fade" id="contact_pers">

              <div class="page-header">
                 <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Contact person details </h3>
            </div>
              <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="form_type" value="contact_details">
                  <input type="hidden" name="comp_name" value="{{$company->comp_name}}">
                  <input type="hidden" name="email" value="{{$company->email}}">

               
           <div class="col-md-5">
               
                  <div class="form-group">
                      {!! Form::label('contact_name', 'Contact Person Name:') !!}
                      {{ Form::input('text', 'contact_name', old('contact_name', $company->contact_name), ['class' => 'form-control']) }}
                     
                  </div>
                  <div class="form-group">
                      {!! Form::label('job_title', 'Job Title:') !!}
                      {{ Form::input('text', 'job_title', old('job_title', $company->job_title), ['class' => 'form-control']) }}
                     
                  </div>
                    <div class="form-group">
                    {!! Form::label('contact_email', ' Contact Person Email:') !!}
                    {{ Form::input('text', 'contact_email', old('contact_email', $company->contact_email), ['class' => 'form-control']) }}
                    
                  </div>
             
              </div>
               <div class="col-md-5">
               
                <div class="form-group">
                    {!! Form::label('contact_mobile', 'Contact Mobile:') !!}
                    {{ Form::input('text', 'contact_mobile', old('contact_mobile', $company->contact_mobile), ['class' => 'form-control'])  }}
                </div>
               <div class="form-group">
                     {!! Form::label( 'Alternate contact emails: separete emails with comma (,)') !!}
                      {{ Form::input('text', 'email1', old('email1', $company->email1), ['class' => 'form-control'])  }}
                </div>
             
              </div>
               <div class="col-md-10">    
              
                  <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary" name="contact_details">Create</button>
                    <a class="btn btn-sm btn-link pull-right" href="{{ route('companies.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>

              </div>
              
            </form>
        </div>
         <div class="row tab-pane fade" id="billing">
              <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                 <input type="hidden" name="form_type" value="billing">
                 <input type="hidden" name="comp_name" value="{{$company->comp_name}}">
                  <input type="hidden" name="email" value="{{$company->email}}">
              <div class="page-header">
                 <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Billing details </h3>
            </div>
           <div class="col-md-5">
            
                <div class="form-group">
                    {!! Form::label('billing_comp_name', 'Billing Company Name:') !!}
                     {{ Form::input('text', 'billing_comp_name', old('billing_comp_name', $company->billing_comp_name), ['class' => 'form-control'])  }}
                </div>
               
                 <div class="form-group">
                    {!! Form::label('billing_contact_person', 'Billing Contact Person:') !!}
                      {{ Form::input('text', 'billing_contact_person', old('billing_contact_person', $company->billing_contact_person), ['class' => 'form-control'])  }}
                </div>
                  <div class="form-group">
                    {!! Form::label('billing_contact_number', 'Billing Contact Number:') !!}
                    {{ Form::input('text', 'billing_contact_number', old('billing_contact_number', $company->billing_contact_number), ['class' => 'form-control'])  }}
                    
                </div>
              
                <div class="form-group">
                    {!! Form::label('billing_country', 'Billing Country:') !!}
                    {{ Form::input('text', 'billing_country', old('billing_country', $company->billing_country), ['class' => 'form-control'])  }}
                   
                </div>
                 <div class="form-group">
                    {!! Form::label('billing_email', 'Billing Email:') !!}
                     {{ Form::input('text', 'billing_email', old('billing_email', $company->billing_email), ['class' => 'form-control'])  }}
                  
                </div>

                      
            </div>
            <div class="col-md-5"> 
             <div class="form-group">
                    {!! Form::label('billing_value', 'Billing Value:') !!}
                    {{ Form::input('text', 'billing_value', old('billing_value', $company->billing_value), ['class' => 'form-control'])  }}
                </div>  
               <div class="form-group">
                    {!! Form::label('vat_tax_gst', 'VAT/TAXID/GSTIN NO:') !!}
                     {{ Form::input('text', 'vat_tax_gst', old('vat_tax_gst', $company->vat_tax_gst), ['class' => 'form-control'])  }}
                     
                </div> 
                 <div class="form-group">
                    {!! Form::label('po_no', 'PO.NO:') !!}
                    {{ Form::input('text', 'po_no', old('po_no', $company->po_no), ['class' => 'form-control'])  }}
                </div> 
                <div class="form-group">
                    {!! Form::label('po_date', 'PO.Date:') !!}
                    {{ Form::input('text', 'po_date', old('po_date', $company->po_date), ['class' => 'form-control','id'=>'po_from'])  }}
                  
                </div>
                 <div class="form-group">                  
                    {!! Form::label('tax', 'Tax:') !!}
                      {{ Form::input('text', 'tax', old('tax', $company->tax), ['class' => 'form-control'])  }}
                  
                </div>

               
            </div>
             <div class="col-md-10">    
              
               <div class="form-group">
                    {!! Form::label('billing_address', 'Billing Address:') !!}
                     {{ Form::textarea('billing_address', old('billing_address',$company->billing_address), ['class' => 'form-control my-editor','size'=>'30x4']) }}
                   
                </div>
                  <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary" name="billing">Create</button>
                    <a class="btn btn-sm btn-link pull-right" href="{{ route('companies.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>

              </div>
               </form>
           </div>
         </div>
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
@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> tenders / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('route' => 'tenders.store','files'=>true)) !!}
                
                <!-- <div class="form-group">
                    {!! Form::label('category_id', 'Category:') !!}
                   {!! \App\Category::attr(['name' => 'category_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->renderAsDropdown() !!}
                </div> -->
                <div class="form-group">
                    {!! Form::label('country_id', 'Country:') !!}
                    {{ Form::select('country_id', $countries, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Country']) }}

                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('issuer', 'Issuer:') !!}
                    {{ Form::input('text', 'issuer', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label(' tender_reference', ' Tender Reference:') !!}
                    {{ Form::input('text', ' tender_reference', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('tender_notice_type', ' Tender Notice Type:') !!}
                    {{ Form::input('text', 'tender_notice_type', null, ['class' => 'form-control','required'=>'required']) }}
                </div> -->
                 <!-- <div class="form-group">
                    {!! Form::label('sector', 'sector:') !!}
                    {{ Form::input('text', 'sector', null, ['class' => 'form-control','required'=>'required']) }}
                </div> -->
                <div class="form-group">
                    {!! Form::label('action_deadline', 'Action deadline:') !!}
                    {{ Form::input('text', 'action_deadline', null, ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('closing_date', 'Closing Date:') !!}
                    {{ Form::input('text', 'closing_date', null, ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>
                
                <div class="form-group">
                    {!! Form::label('issue_date', 'Isuue Date:') !!}
                    {{ Form::input('text', 'issue_date', null, ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('region', 'Region:') !!}
                    {{ Form::input('text', 'region', null, ['class' => 'form-control']) }}
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('meeting_compulsary', 'Meeting Compulsary:') !!}

                    <select name="meeting_compulsary" class="form-control" required="required">
                        <option value="">-- Meeting Compulsary --</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div> -->
                
               <!--  <div class="form-group">
                    {!! Form::label('meeting_date', 'Meeting Date:') !!}
                    {{ Form::input('text', 'meeting_date', null, ['class' => 'form-control datepicker']) }}
                </div> -->
               
                <div class="form-group">
                    {!! Form::label('tender_url', 'tender Url:') !!}
                    {{ Form::input('text', 'tender_url', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('home_title', 'Home Title:') !!}
                    {{ Form::input('text', 'home_title', null, ['class' => 'form-control']) }}
                </div>
              
                <div class="form-group">
                    {!! Form::label('home_description', 'Home Description:') !!}
                    {{ Form::textarea('home_description', null, ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null, ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
              
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('tenders.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
  
<script>
      $('textarea.my-editor').ckeditor();
</script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>
   $( function() {
    $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
  } );
  </script>
  @endsection
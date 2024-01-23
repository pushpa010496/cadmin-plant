@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Tenders / Edit #{{$tender->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <form action="{{ route('tenders.update', $tender->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- <div class="form-group">
                    {!! Form::label('category_id', 'Category:') !!}
                   {!! \App\Category::attr(['name' => 'category_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($tender->category_id)
                   ->renderAsDropdown() !!}
                </div> -->
                <div class="form-group">
                    {!! Form::label('country_id', 'Country:') !!}
                    {{ Form::select('country_id', $countries, old('country_id',$tender->country_id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Country']) }}

                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', old('title',$tender->title), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('issuer', 'Issuer:') !!}
                    {{ Form::input('text', 'issuer', old('issuer',$tender->issuer), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label(' tender_reference', ' Tender Reference:') !!}
                    {{ Form::input('text', ' tender_reference', old('tender_reference',$tender->tender_reference), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('tender_notice_type', ' Tender Notice Type:') !!}
                    {{ Form::input('text', 'tender_notice_type', old('tender_notice_type',$tender->tender_notice_type), ['class' => 'form-control','required'=>'required']) }}
                </div> -->
                 <!-- <div class="form-group">
                    {!! Form::label('sector', 'Sector:') !!}
                    {{ Form::input('text', 'sector', old('sector',$tender->sector), ['class' => 'form-control','required'=>'required']) }}
                </div> -->
                 <div class="form-group">
                    {!! Form::label('action_deadline', 'Action deadline:') !!}
                    {{ Form::input('text', 'action_deadline', old('action_deadline',$tender->action_deadline), ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>
                
                <div class="form-group">
                    {!! Form::label('closing_date', 'Closing Date:') !!}
                    {{ Form::input('text', 'closing_date', old('closing_date',$tender->closing_date), ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>
                
                <div class="form-group">
                    {!! Form::label('issue_date', 'Isuue Date:') !!}
                    {{ Form::input('text', 'issue_date', old('issue_date',$tender->issue_date), ['class' => 'form-control datepicker','required'=>'required']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('region', 'Region:') !!}
                    {{ Form::input('text', 'region', old('region',$tender->region), ['class' => 'form-control']) }}
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('meeting_compulsary', 'Meeting Compulsary:') !!}
                    {{ Form::select('meeting_compulsary',  [''=>'-- Meeting Compulsary --','1'=>'Yes','0'=>'No',], old('meeting_compulsary',$tender->meeting_compulsary), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Country']) }}
                    
                </div> -->
                
               <!--  <div class="form-group">
                    {!! Form::label('meeting_date', 'Meeting Date:') !!}
                    {{ Form::input('text', 'meeting_date', old('meeting_date',$tender->meeting_date), ['class' => 'form-control datepicker']) }}
                </div> -->
               
                
                <div class="form-group">
                    {!! Form::label('tender_url', 'tender Url:') !!}
                    {{ Form::input('text', 'tender_url', old('tender_url',$tender->tender_url), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$tender->description), ['class' => 'form-control my-editor','size'=>'30x4']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('home_title', 'Home Title:') !!}
                    {{ Form::input('text', 'home_title', old('home_title',$tender->home_title), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('home_description', 'Home Description:') !!}
                    {{ Form::textarea('home_description', old('home_description',$tender->home_description), ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($tender->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($tender->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('tenders.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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
 $('textarea.my-editor').ckeditor();
</script>

@endsection

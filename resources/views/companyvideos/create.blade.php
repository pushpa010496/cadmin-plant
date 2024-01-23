@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Company Videos / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'companyvideos.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_profile_id', 'Select Profile:') !!}
                    {!! Form::select('company_profile_id',[''=>'--- Select One ---'],null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'videos Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 
                  <div class="form-group">
                    {!! Form::label('video', 'Upload Videos:') !!}
                     {!! Form::file('video', array('class' => '')) !!}
                </div>
              
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                <div class="form-group">
                  {!! Form::label('stage', 'Stage:') !!}
                  <select name="stage" class="form-control" required="required">
                    <option value="">-- Select one --</option>
                    <option value="1">Live</option>
                    <option value="0">Test</option>
                  </select>
                </div>
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('companyvideos.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>  
          
               
            </form>
        </div>
    </div>
@endsection

@section('scripts')

<script type="text/javascript">
  $("select[name='company_id']").change(function(){
      var company_id = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo url('select-ajax') ?>",
          method: 'GET',
          data: {company_id:company_id, _token:token},
          success: function(data) {
            $("select[name='company_profile_id'").html('');
            $("select[name='company_profile_id'").html(data.options);
          }
      });
  });
</script>
@endsection
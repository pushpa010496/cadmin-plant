@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3> Company Profile / Edit #{{$companycatalog->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-3 col-md-8 col-md-offset-3">

            <form action="{{ route('companycatalogs.update', $companycatalog->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

             {!! Form::open(array('route' => 'companycatalogs.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, old('company_id',$companycatalog->company_id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_profile_id', 'Select Profile:') !!}
                    {!! Form::select('company_profile_id',$profilelist,old('company_profile_id',$companycatalog->company_profile_id),['class'=>'form-control','placeholder'=>'Select Profile']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Catalogs Title:') !!}
                    {{ Form::input('text', 'title', old('title',$companycatalog->title), ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('display_order', 'Display Order:') !!}
                    {{ Form::input('number', 'display_order', old('display_order',$companycatalog->display_order), ['class' => 'form-control','required'=>'required']) }}
                </div>

                 <div class="form-group">
                    {!! Form::label('image', 'Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                      @if($companycatalog->image)
                       <img width="100" src="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug($companycatalog->company->comp_name);?>/catalog/<?php echo $companycatalog->image;?>">
                     @endif
                </div>
                 
                <div class="form-group">
                    {!! Form::label('title_tag', 'Img Title:') !!}
                    {{ Form::input('text', 'title_tag',  old('title_tag',$companycatalog->title_tag), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('alt_tag', 'Img Alt:') !!}
                    {{ Form::input('text', 'alt_tag',  old('alt_tag',$companycatalog->alt_tag), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('pdf', 'PDF:') !!}
                     {!! Form::file('pdf', array('class' => '')) !!}
                      @if($companycatalog->pdf)
                      <a href="<?php echo config('app.url'); ?>suppliers/<?php echo str_slug(str_slug($companycatalog->company->comp_name));?>/catalog/<?php echo $companycatalog->pdf;?>">View PDF</a>
                     @endif
                </div>

                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}

                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($companycatalog->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($companycatalog->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    {!! Form::label('stage', 'Stage:') !!}

                    <select name="stage" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($companycatalog->stage == 1)
                        <option value="1" selected="selected">Live</option>
                        <option value="0">Test</option>
                        @elseif($companycatalog->stage == 0)
                        <option value="1">Live</option>
                        <option value="0" selected="selected">Test</option>
                        @endif
                    </select>
                </div>
                               
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    
                     <a class="btn btn-sm btn-default pull-right" href="{{ route('companycatalogs.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
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
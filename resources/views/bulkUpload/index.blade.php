@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i> Bulk Upload
        </h3>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
               <form action="{{ url('bulkupload') }}" method="POST" enctype="multipart/form-data" files="true" name="form1" id="form1">
                            {{ csrf_field()}}
                             <h5><strong>select companies zip file</strong></h5>
                          
                            <div class="col-md-4">
                                {!! Form::file('companiesfile', array('class' => '')) !!}
                          </div>
                          <div class="col-md-12">
                            <button type="submit" name="Submit" class="btn btn-primary ">Upload</button>
                          </div>  
                       </form>

        </div>
    </div>

@endsection
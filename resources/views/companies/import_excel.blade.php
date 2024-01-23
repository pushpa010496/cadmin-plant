@extends('../layouts/app')


@section('content')

        <div class="container-fluid">
          



 <h3 align="center">Select Company Excel File</h3>
    <br />
   @if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">.xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>
   
   <br />
    <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Company Data</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>Company Name</th>
        <th>Phone</th>
        <th>email</th>
        <th>services</th>
        <th>Technology</th>
        <th>Profile Type</th>
       </tr>
       @foreach($data as $row)
       <tr>
        <td>{{ @$row->comp_name }}</td>
        <td>{{ @$row->phone }}</td>
        <td>{{ @$row->email }}</td>
        <td>{{ @$row->services }}</td>
        <td>{{ @$row->technology }}</td>
        <td>{{ @$row->profile_type }}</td>
       </tr>
       @endforeach
      </table>
     </div>
    </div>
   </div> 
  </div>


                                </div>
                         
@endsection
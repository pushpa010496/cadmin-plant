@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Missing List #</h3>
    </div>
@endsection

@section('style')
<style type="text/css">
  .bg-white{
    background-color:#fff; 
  }
  .text-white{
    color:#fff !important;
  }
  table{
    color: #4c4c4c !important;
  }
  table > tbody > tr > td, .table > tbody > tr > td,
  table > thead > tr > th, .table > thead > tr > th,
  table > tbody > tr > th, .table > tbody > tr > th{
    border-color:#ddd; 
  }
</style>
@endsection

@section('content')
   
      <div class="container">
        

        <div class="row">   
        <div class="col-md-12 bg-white">
          @php $count = 1; @endphp
       @foreach($errors as $error)
              <table class="table table-bordered" width="100%">
               <thead>
                <tr>
                  
                  <th colspan='12'>{{$count}} ) {{ $error['company'] }} </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th colspan="4" class="text-white bg-info">Products</th>
                  <th colspan="2" class="text-white bg-primary">Press releases</th>
                  <th colspan="2" class="text-white bg-success">white papers</th>
                  <th colspan="2" class="text-white bg-danger">catalogues</th>
                  <th colspan="2" class="text-white bg-warning">videos</th>
                </tr>

                 <tr>
                  <th class="text-white bg-info">Product name</th>                
                  <th class="text-white bg-info">small Image</th>  
                  <th class="text-white bg-info">Big Image</th>
                  <th class="text-white bg-info">Document</th>

                  <th class="text-white bg-primary">Press image</th>
                  <th class="text-white bg-primary">Press PDF</th>

                  <th class="text-white bg-success">White image</th>
                  <th class="text-white bg-success">White PDF</th>

                  <th class="text-white bg-danger">catl image</th>
                  <th class="text-white bg-danger">catl PDF</th>

                  <th class="text-white bg-warning">video name</th>
                  <th class="text-white bg-warning">video</th>
                </tr>


                @foreach($error['data'] as $data)
                <tr>
                  <td>{{@$data['product']}}</td>
                  <td>{{@$data['small_image']}}</td>
                  <td>{{@$data['big_image']}}</td>
                  <td>{{@$data['document']}}</td>

                  <td>Press image</td>
                  <td>Press pdf</td>
                  <td>white Vwhitewhitewhitewh itewhite whitewhite image</td>
                  <td>white pdf</td>

                  <td>catl image</td>
                  <td>catl pdf</td>

                  <td>video name</td>
                  <td>video.mp4</td>
                </tr>
                @endforeach
              
                                      
              </tbody>
            </table>
            @php $count = $count+1; @endphp
           @endforeach

     
       </div>
       </div>        
    </div>
@endsection
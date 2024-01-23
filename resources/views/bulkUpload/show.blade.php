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
  table,.table{
    color: #4c4c4c !important;
    margin-top: 15px;
  }
  table > tbody > tr > td, .table > tbody > tr > td,
  table > thead > tr > th, .table > thead > tr > th,
  table > tbody > tr > th, .table > tbody > tr > th{
    border-color:#ddd; 
  }
  .cmp_bg{
    background: #058798;
  }
  .bg-blue{
    background: #3097d1;
    color: #fff !important;
  }
  .bg-purple{
    background: #a956b7;
    color: #fff !important;
  }
  
</style>
@endsection

@section('content')
   
      <div class="">
        

        <div class="row">   
        <div class="col-md-12 bg-white">

          @php $count = 1; @endphp
       @foreach($errors as $error)
              <table class="table table-bordered" width="100%">
               <thead>
                <tr>
                  
                  <th colspan='14' class="cmp_bg text-white">{{$count}} ) {{ $error['company'] }} </th>
                </tr>
                <tr>
                  <th >Profile FIle :</th>
                  <th colspan="3">{{  @$error['profile']?$error['profile']:'Success' }}</th>
                  <th colspan="2">Company logo :</th>
                  <th colspan="3">{{ @$error['logo']?$error['logo']:'success' }}</th>
                  <th colspan="2">Sheet :</th>
                  <th colspan="3">{{ @$error['xlxs_sheet']?$error['xlxs_sheet']:'success' }}</th>
                </tr>
                @if( @$error['company_sheet']  == '0')
                <tr>
                  <th colspan="13" class="bg-danger">Company Sheet Missing</th>                  
                </tr>

                @else
                <tr>
                  <th  class="{{ @$error['name'] != '0' ?'bg-success':'bg-danger' }}">Company Name</th>
                  <th  class="{{ @$error['contact_name'] != '0' ?'bg-success':'bg-danger' }}">Coontact Person</th>
                  <th  class="{{ @$error['duplicate'] != '0' ?'bg-success':'bg-danger' }}">Duplicate Company</th>
                  <th  class="{{ @$error['email'] != '0' ?'bg-success':'bg-danger' }}" colspan="2">Company Email</th>
                  <th  class="{{ @$error['country'] != '0' ?'bg-success':'bg-danger' }}" colspan="2">Country</th>
                  <th  class="{{ @$error['website'] != '0' ?'bg-success':'bg-danger' }}" colspan="2">Web site</th>
                  <th  class="{{ @$error['phone'] != '0' ?'bg-success':'bg-danger' }}">Phone</th>
                  <th colspan="2" class="{{ @$error['clogo'] != '0' ?'bg-success':'bg-danger' }}">Company Logo</th>
                  <th  class="{{ @$error['address'] != '0' ?'bg-success':'bg-danger' }}" colspan="2">Address</th>
                </tr>                
                @endif
              </thead>
              <tbody>
                <tr>
                  <th colspan="6" class="text-white bg-info">Products</th>
                  <th colspan="2" class="text-white bg-primary">Press releases</th>
                  <th colspan="2" class="text-white bg-purple">white papers</th>
                  <th colspan="2" class="text-white bg-blue">catalogues</th>
                  <th colspan="2" class="text-white bg-warning">videos</th>
                </tr>

                 <tr>
                  <th class="text-white bg-info">Product name</th>   
                  <th class="text-white bg-info">Category</th>   
                  <th class="text-white bg-info">small Image</th>  
                  <th class="text-white bg-info">Big Image</th>
                  <th class="text-white bg-info">Document</th>
                  <th class="text-white bg-info">Techspec</th>

                  <th class="text-white bg-primary">Press image</th>
                  <th class="text-white bg-primary">Press PDF</th>

                  <th class="text-white bg-purple">White image</th>
                  <th class="text-white bg-purple">White PDF</th>

                  <th class="text-white bg-blue">catl image</th>
                  <th class="text-white bg-blue">catl PDF</th>

                  <th class="text-white bg-warning">video name</th>
                  <th class="text-white bg-warning">video</th>
                </tr>

                @if(@$error['data'] != '')  
                  @foreach($error['data'] as $data)
                  <tr>
                    <td>{{@$data['product']}}</td>
                    <td>{{@$data['category']}}</td>
                    <td>{{@$data['small_image']}}</td>
                    <td>{{@$data['big_image']}}</td>                    
                    <td>{{@$data['document']}}</td>
                    <td>{{@$data['tech_spec_pdf']}}</td>

                    <td>{{@$data['press_image']}}</td>
                    <td>{{@$data['press_pdf']}}</td>

                     <td>{{@$data['white_image']}}</td>
                    <td>{{@$data['white_pdf']}}</td>

                    <td>{{@$data['cat_image']}}</td>
                    <td>{{@$data['cat_pdf']}}</td>

                   <td>{{@$data['video_name']}}</td>
                    <td>{{@$data['video']}}</td>
                  </tr>
                  @endforeach
                @endif
              
                                      
              </tbody>
            </table>
            @php $count = $count+1; @endphp
           @endforeach

     
       </div>
       </div>        
    </div>
@endsection
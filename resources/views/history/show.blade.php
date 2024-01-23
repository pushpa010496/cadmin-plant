@extends('../layouts/app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
           <div class="page-header clearfix">
            <h3 class=" pull-left"> History for {{$company->comp_name}} </h3>  
                     
        </div>        
        </div>
       
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
         @if($company_history)
             <h3 class=" pull-left"> company history </h3>  
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                                                  
                          
                            <th><h5>Name</h5></th>
                            <th><h5>Email</h5></th>
                            <th><h5>Country</h5></th>
                            <th><h5>phone</h5></th>
                            <th><h5>Website</h5></th>
                            <th><h5>Updated By</h5></th>
                            <th><h5>created Date</h5></th>   
                            <th><h5>updated Date</h5></th>                                                     
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($company_history as $value)
              
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                            
                                <td><h5><a href="{{route('history-views',$value->id)}}" data-toggle="modal" data-target="#show_model">{{$value->comp_name}}</a></h5></td>
                                <td><h5>{{$value->email}}</h5></td>
                                <td><h5>{{$value->country}}</h5></td>
                                <td><h5>{{$value->phone}}</h5></td>
                                <td><h5>{{$value->website}}</h5></td>
                                <td><h5>{{$value->author->name}}</h5></td>
                                <td><h5>{{$value->created_at->format('d/M/Y H:i:s')}}</h5></td>
                                <td><h5>{{$value->updated_at->format('d/M/Y H:i:s')}}</h5></td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
            @endif
               @if($contact_details)
             <h3 class=" pull-left">Contact Person history </h3>  
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                           <th class="text-center"><h5>#</h5></th>
                            <th><h5>Contact Name</h5></th>
                            <th><h5>Job Title</h5></th>
                            <th><h5>Contact Email</h5></th>
                            <th><h5>Contact Mobile</h5></th>
                            <th><h5>Alternate email</h5></th>
                            <th><h5>Updated By</h5></th>
                            <th><h5>created at</h5></th>   
                            <th><h5>updated at</h5></th>                                                      
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($contact_details as $value)
              
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->contact_name}}</h5></td>
                                <td><h5>{{$value->job_title}}</h5></td>
                                <td><h5>{{$value->contact_email}}</h5></td>
                                <td><h5>{{$value->contact_mobile}}</h5></td>
                                <td><h5>{{$value->email1}}</h5></td>
                                <td><h5>{{$value->author->name}}</h5></td>
                                <td><h5>{{$value->created_at->format('d/M/Y H:i:s')}}</h5></td>
                                <td><h5>{{$value->updated_at->format('d/M/Y H:i:s')}}</h5></td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
            @endif
             @if($billing_details)
             <h3 class=" pull-left"> Billing history </h3>  
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                           <th class="text-center"><h5>#</h5></th>
                            <th><h5>Company Name</h5></th>
                            <th><h5>Billing Person</h5></th>
                            <th><h5>Billing Email</h5></th>
                            <th><h5>Billing Value</h5></th>
                            <th><h5>Vat/Tax/Gst</h5></th>
                            <th><h5>Updated By</h5></th>
                            <th><h5>created at</h5></th>   
                            <th><h5>updated at</h5></th>                                                      
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($billing_details as $value)
              
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5><a href="{{route('billing-views',$value->id)}}" data-toggle="modal" data-target="#showbilling_model">{{$value->billing_comp_name}}</a></h5></td>
                                <td><h5>{{$value->billing_contact_person}}</h5></td>
                                <td><h5>{{$value->billing_email}}</h5></td>
                                <td><h5>{{$value->billing_value}}</h5></td>
                                <td><h5>{{$value->vat_tax_gst}}</h5></td>
                                <td><h5>{{$value->author->name}}</h5></td>
                                <td><h5>{{$value->created_at->format('d/M/Y H:i:s')}}</h5></td>
                                <td><h5>{{$value->updated_at->format('d/M/Y H:i:s')}}</h5></td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    </div>
<div class="modal fade" id="show_model" tabindex="-1" role="dialog" aria-labelledby="show_model" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade" id="showbilling_model" tabindex="-1" role="dialog" aria-labelledby="showbilling_model" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
@endsection 
@section('scripts')
<script type="text/javascript">
    
$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
</script>
@stop
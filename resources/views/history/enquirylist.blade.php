@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Enquiries List
                                 
                </h3>               
            </div>

        </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            @if($data->count())
              {!! Form::open(array('route' => 'enquiry-send')) !!}
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5>Name</h5></th>                           
                            <th><h5>Company</h5></th>                           
                            <th><h5>Email</h5></th>  
                            <th><h5>Enquiry for</h5></th>  
                            <th><h5>Created at</h5></th>  
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                      

                        @foreach($data as $value)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->name}}</h5></td>
                                <td><h5>{{$value->company}}</h5></td>
                                <td><h5>{{$value->email}}</h5></td>
                                <td>
                                 @if($value->sent_to_client == 0)
                                    <input type="checkbox" name="enquiries[]" value="{{$value->id}}">{{$value->companies->comp_name}}
                                 @else   
                                 <h5>{{$value->companies->comp_name}}</h5>
                                 @endif    
                                     
                                  
                                </td>      
                                <td><h5>{{$value->created_at}}</h5></td>                         
                                <td class="text-right">
                                                                                  
                                     <a class="btn btn-sm btn-primary" href="{{ route('enquiry-view', $value->id) }}" data-toggle="modal" data-target="#show_model"><i class="fa fa-eye" aria-hidden="true"></i> View</a>

                                </td>
                                 @if($value->sent_to_client == 0)
                                    <td class="text-right">
                                                                                  
                                     <a class="btn btn-sm btn-primary" href="{{ route('enquiry-edit', $value->id) }}" data-toggle="modal" data-target="#edit_model"><i class="fa fa-eye" aria-hidden="true"></i> Edit</a>

                                    </td>
                                  @endif
                            </tr><?php $i++; ?>
                           

                        @endforeach
                        
                     
                    </tbody>
                </table>
                <input type="submit" name="" class="form-control btn-info" value="Send Enquiries to Client" /> 
                     </form>
                {!! $data->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
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
<div class="modal fade" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="edit_model" aria-hidden="true">
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
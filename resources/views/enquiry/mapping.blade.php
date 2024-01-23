@extends('../layouts/app')

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
  .select2-container{
    width: 100% !important;
    color: #111 !important;
  }
</style>
@endsection

@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Company Enquiries
                    
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'enquiries-mapping','role'=>'search'])  !!}
              <div id="custom-search-input">
                <div class="input-group col-md-12 pull-right">
                    <input type="text" class="search-query form-control" placeholder="Search" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>

                        </button>
                    </span>
                </div>
              </div>
         {!! Form::close() !!}
        </div>
        <div>&nbsp;<br/></div>
        </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            @if($enquiries->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5> Name</h5></th>                           
                            <th><h5> Company</h5></th>                           
                            <th><h5>Enquiry for</h5></th>  
                            <th><h5>Email</h5></th>

                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($enquiries as $value)
                        <tr>
                            <td class="text-center"><h5>{{$i}}</h5></td>
                            <td><h5>{{$value->name}}</h5></td>
                            <td><h5>{{$value->company}}</h5></td>
                            <td><h5>{{ @$value->companies->comp_name }}</h5></td>
                            <td><h5>{{$value->email}}</h5></td>

                            <td class="text-right">                                                                    
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update?</button>
                            </td>
                        </tr><?php $i++; ?>

                         <!-- Modal -->
                        <div id="myModal{{$value->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Enquiry</h4>
                              </div>
                              <div class="modal-body">
                                  {!! Form::open(array('url'=>'enquiries-mapping/'.$value->id)) !!}
                                   <div class="form-group">
                                      {{ Form::input('text', 'name',  @$value->name, ['class' => 'form-control', 'disabled' => 'disabled' ]) }}
                                  </div>
                                   <div class="form-group">
                                      {{ Form::input('text', 'company',  @$value->company, ['class' => 'form-control', 'disabled' => 'disabled' ]) }}
                                  </div>
                                   <div class="form-group">

                                      {{ Form::input('text', 'email',  @$value->email, ['class' => 'form-control', 'disabled' => 'disabled' ]) }}
                                  </div>

                                  <div class="form-group">
                                    <textarea disabled="" class="form-control" rows="5">{{@$value->message}}</textarea>
                                      
                                  </div>

                                   <div class="form-group">
                                      {!! Form::select('company_id', $companies, $value->company_id, ['class' => 'form-control company_select','required' => 'required']) !!}
                                  </div>
                                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                  {!! Form::close() !!}
                               </div>
                               <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                               </div>
                            </div>
                          </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
                {!! $enquiries->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>


   
@endsection 
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script type="text/javascript">
   $('.company_select').select2();
</script>
@endsection
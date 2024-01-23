@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
          <div class="alert alert-warning">
            <strong>Warning!</strong> Data can move to live state which are the records inactive mode...
          </div>
             <div class="clearfix">
                <h3>Uploaded Data</h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'movedata','role'=>'search'])  !!}
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
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
           
            @if($companies->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>Company ID</h5></th>                           
                            <th><h5>Company Name</h5></th>     
                              
                            
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($companies as $value)
                            <tr>
                                <td class="text-center"><strong><h5>{{$i}}</h5></strong></td>
                                <td><h5>{{$value->id}}</h5></td>
                                <td><h5>{{@$value->comp_name}}</h5></td>
                                
                             
                                <td class="text-right">
                                   <!--  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update Metatags ?</button>
                                    <a class="btn btn-sm btn-success" href="{{ url('products/reactivate', $value->id) }}">
                                         Active ?
                                    </a> -->
                                    <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-primary moveBtn">
                                      Move to live
                                    </button>
                                   
                                    
                                    {{-- <a class="btn btn-sm btn-warning" href="{{ route('products.edit', $value->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a> --}}

                                  {{--   <form action="{{ route('products.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form> --}}
                                </td>
                            </tr><?php $i++; ?>


                              <!-- Modal -->
                                <div id="myModal{{$value->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update Metatags</h4>
                                      </div>
                                      <div class="modal-body">
                                          {!! Form::open(array('url'=>'products/metatag/'.$value->id)) !!}
                                             @includeIf('./seoform')
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
                {{-- {!! $products->render() !!} --}}
                  {!! $companies->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
    </div>

<!-- Modal -->
<div id="move" class="modal fade" role="dialog">
    <!-- Modal content-->
     <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Danger Alert</h4>
        </div>
        <div class="modal-body">
          <p>Do you want to move all records to live... Once you done can't revert</p>
        </div>
        <div class="modal-footer">
            <a href="" class="btn btn-danger">Move</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


     <!-- Modal for same page Success flash -->
  <div class="modal fade" id="success" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
          <h4 class="modal-title">Success</h4>
        </div>
        <div class="modal-body">
          <p>All data moved Successfully....</p>
        </div>
        <div class="modal-footer">
           <a href="{{Request::url()}}" class="btn btn-info text-right">Close</a>
          {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
        </div>
      </div>
      
    </div>
  </div>

@endsection 

@section('scripts')
<script type="text/javascript">
  $('.moveBtn').on('click',function(){
      var url = "{{ url('/')}}"+"/movedata/"+ $(this).attr('data-id');
      $('#move a').prop('href',url);
      $('#move').modal('show');
  });


</script>
@if(session('success'))
    <script type="text/javascript">
           $('#success').modal('show');
    </script>
@endif
@endsection


















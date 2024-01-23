@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
              
                    <a class="btn btn-success pull-right" href="{{ route('create_product_landingpages') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
             {!! Form::open(['method'=>'GET','url'=>'product_landingpages','role'=>'search'])  !!}
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
           @if($product_landingpages->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>Title</h5></th>                           
                            <th><h5>Products</h5></th> 
                            <th class="text-center"><h5>Status</h5></th> 
                            <th class="text-right"><h5>OPTIONS</h5></th
                            <th class="text-right"><h5>Product Landing Page</h5></th>
                            
                        </tr>
                    </thead>
                 <tbody><?php $i=1; ?>
              @foreach($product_landingpages as $landingpage)
              @php
              $url = "{{$landingpage->url}}";
              @endphp
             <tr>
             <td>{{ $i }} </td>
                 <td>{{ $landingpage->title }} </td>
                 <td>
                     <ul>
                 @foreach(getproductnames($landingpage->products_id) as $item)
                
                    <li>{{ $item->title }}</li>
                
                 @endforeach
                 </ul>
                 </td>
                 <td class="text-center">
                                    <h5>
                                          @if($landingpage->active_flag ==1) Active @elseif($landingpage->active_flag == 0) Inactive @endif
                                    </h5>
                                </td>
                   <td class="text-right">
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$landingpage->id}}"> Update Metatags ?</button>
                        <a class="btn btn-sm btn-warning" href="{{ route('edit_product_landingpages',$landingpage->id) }}">
                           <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                        </a>
                        <!-- <a class="btn btn-sm btn-success" href="{{ url('product_landingpages/reactivate', $landingpage->id) }}">
                                         Active ?
                                    </a> -->
                        <form action="{{ route('destroy_product_landingpages', $landingpage->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                    </td>
                   
                    <td class="text-right">
                        <a class="btn btn-sm btn-info" href="https://www.plantautomation-technology.com/imppro/{{$landingpage->url}}" > Product Landing Page</a>
                       
                    </td>
             </tr><?php $i++; ?>

             <div id="myModal{{$landingpage->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update Metatags</h4>
                                      </div>
                                      <div class="modal-body">
                                          {!! Form::open(array('url'=>'product_landingpages/metatag/'.$landingpage->id)) !!}
                                             @includeIf('./seoform1')
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
              {!! $product_landingpages->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
         
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection 
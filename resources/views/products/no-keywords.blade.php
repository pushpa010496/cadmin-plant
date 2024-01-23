@extends('../layouts/app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            @if($keywords->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>keyword</h5></th>                           
                            <th><h5>Url</h5></th> 
                            <!--<th><h5>Status</h5></th> -->
                            <!--<th class="text-right"><h5>OPTIONS</h5></th>-->
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($keywords as $value)
                            <tr>
                                <td class="text-center"><strong><h5>{{$i}}</h5></strong></td>
                                <td><h5>{{str_replace('-',' ',$value->keyword)}}</h5></td>
                                <td><h5>{{@$value->url}}</h5></td>
                                <!-- <td>-->
                                <!--  @if($value->status =='1')-->
                                <!--  <a class="btn btn-sm btn-success" href="{{url('product-keyword/redeactive',$value->id)}}">Active ?</a>-->
                                <!--  @else-->
                                <!--  <a class="btn btn-sm btn-danger" href="{{url('product-keyword/reactivate',$value->id)}}">In-Active ?</a>-->
                                <!--  @endif-->
                                <!--</td>-->
                                <!--<td>-->
                                      
                                <!--</td>-->
                                <!--<td class="text-right">-->
                                <!--  <form action="{{url('product-keyword/delete')}}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">-->
                                <!--       @csrf-->
                                <!--        <input type="hidden" name="id" value="{{$value->id}}">-->
                                <!--        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>-->
                                <!--     </form>-->

                                <!--    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update Metatags ?</button>-->
                                <!--</td>-->
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
                                          {!! Form::open(array('url'=>'products/keywordmetatag/'.$value->id)) !!}
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
                {!! $keywords->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection 
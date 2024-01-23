@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-3 col-md-6">
             <div class="page-header clearfix">
                <h3>
                     Event Category
                    <a class="btn btn-success pull-right" href="{{ route('event-categories.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'event-categories','role'=>'search'])  !!}
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
        </div>

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            @if($eventcategories->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>eventCategory Name</th>       
                        <!--     <th>Parent</th>                    --> 
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($eventcategories as $value)
                            <tr>
                                <td class="text-center"><strong>{{$i}}</strong></td>
                                <td>{{$value->name}}</td>
                            <!--     
                                <td>{!! \App\EventCategory::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($value->parent_id)
                   ->renderAsDropdown() !!}</td> -->
                                
                                <td class="text-right">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update Metatags ?</button>
                                    <a class="btn btn-sm btn-primary" href="{{ route('event-categories.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-warning" href="{{ route('event-categories.edit', $value->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('event-categories.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
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
                                          {!! Form::open(array('route'=>['event-categories.meta',$value->id])) !!}
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
                {!! $eventcategories->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
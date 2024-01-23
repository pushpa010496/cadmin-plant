@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
             <div class="page-header clearfix">
                <h3>
                     Product Tags
                    <a class="btn btn-success pull-right" href="{{ route('tags.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'tags','role'=>'search'])  !!}
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
            @if($tags->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>Sub_category </h5></th>                           
                            <th><h5>Tag Name</h5></th>  
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($tags as $value)
                            <tr>
                                <td class="text-center"><strong><h5>{{$i}}</h5></strong></td>
                                  <td> <h5>
                                
                                      @foreach ($value->categories->where('active_flag',1) as $ct)
                                      {{ $ct->name }}
                                      @endforeach
                                    </h5>
                                </td>
                               
                                <td><h5>{{$value->tag_name}}</h5></td>
                              
                                <td class="text-right">
                                   
                                    <a class="btn btn-sm btn-primary" href="{{ route('tags.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-warning" href="{{ route('tags.edit', $value->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('tags.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                             <!-- Modal -->
                            
                        @endforeach
                    </tbody>
                </table>
                {!! $tags->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
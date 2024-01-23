@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i> Article
            <a class="btn btn-sm btn-success pull-right" href="{{ route('articles.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Create</a>
        </h3>
    </div>
    <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'articles','role'=>'search'])  !!}
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
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($articles->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Id</th>
                            <th class="text-left">Title</th>                            
                            <th class="text-left">Url</th>                            
                            <th class="text-left">Status</th>                            
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($articles as $value)
                            <tr>
                                <td class="text-left"><strong>{{$i}}</strong></td>
                                <td class="text-left"><strong>{!! $value->article_title!!}</strong></td>
                                <td class="text-left"><strong>{{$value->article_url}}</strong></td>
                                <td class="text-left">
                                    @if($value->active_flag ==1) Active @elseif($value->active_flag == 0) Inactive @endif
                                </td>
                                <td class="text-right">
                                    <!--  <a class="btn btn-sm btn-info" href="{{ url('articles/metatag', $value->id) }}">
                                        Update Metatags ?
                                    </a>
 -->
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update Metatags ?</button>

                                    <a class="btn btn-sm btn-success" href="{{ url('articles/reactivate', $value->id) }}">
                                         Active ?
                                    </a>                                   

                                    <a class="btn btn-sm btn-primary" href="{{ route('articles.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-info" href="{{ route('articles.edit', $value->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('articles.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
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
                                          {!! Form::open(array('url'=>'articles/metatag/'.$value->id)) !!}
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
                {!! $articles->render() !!}
            @else
                <h3 class="text-left alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>


  

@endsection
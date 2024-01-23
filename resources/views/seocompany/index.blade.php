@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Company SEO
                    <a class="btn btn-success pull-right" href="{{ route('seocompanies.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'seocompanies','role'=>'search'])  !!}
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
            @if($seocompany->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>Meta Title</h5></th>                           
                            <th><h5>Company Profile Name</h5></th>     
                            <th><h5>Page</h5></th>     
                            <th class="text-center"><h5>Status</h5></th> 
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($seocompany as $value)
                            <tr>
                                <td class="text-center"><strong><h5>{{$i}}</h5></strong></td>
                                <td><h5>{{$value->meta_title}}</h5></td>
                                <td><h5>{{@$value->seocompanypro->title}}</h5></td>
                                <td><h5>{{@$value->pages}}</h5></td>
                                <td class="text-center">
                                    <h5>
                                          @if($value->active_flag ==1) Active @elseif($value->active_flag == 0) Inactive @endif
                                    </h5>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-success" href="{{ url('seocompany/reactivate', $value->id) }}">
                                         Active ?
                                    </a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('seocompanies.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-warning" href="{{ route('seocompanies.edit', $value->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('seocompanies.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                {!! $seocompany->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
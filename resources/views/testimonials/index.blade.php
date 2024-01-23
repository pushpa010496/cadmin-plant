@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i> Testimonials
            <a class="btn btn-sm btn-success pull-right" href="{{ route('testimonials.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Create</a>
        </h3>
    </div>
    <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'testimonials','role'=>'search'])  !!}
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
            @if($testimonials->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Name</th>                            
                            <th class="text-center">Company</th>                            
                            <th class="text-center">Status</th>                            
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($testimonials as $testimonial)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td class="text-center"><h5>{{$testimonial->client_name}}</h5></td>
                               
                                <td class="text-center"><h5>{{$testimonial->company_name}}</h5></td>
                                <td class="text-center">
                                    <h5>
                                          @if($testimonial->active_flag ==1) Active @elseif($testimonial->active_flag == 0) Inactive @endif
                                    </h5>
                                </td>
                                <td class="text-right">
                                    
                                    <a class="btn btn-sm btn-success" href="{{ url('testimonials/reactivate', $testimonial->id) }}">
                                         Active ?
                                    </a>

                                    <a class="btn btn-sm btn-primary" href="{{ route('testimonials.show', $testimonial->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-info" href="{{ route('testimonials.edit', $testimonial->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                {!! $testimonials->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>

@endsection
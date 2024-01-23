@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i> Sliders
            <a class="btn btn-sm btn-success pull-right" href="{{ route('sliders.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Create</a>
        </h3>
    </div>
    <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'sliders','role'=>'search'])  !!}
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
            @if($sliders->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Name</th>                            
                            <th class="text-center">Status</th> 
                            <th class="text-center">From</th>  
                            <th class="text-center">To</th>                                
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($sliders as $slider)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td class="text-center"><h5>{{$slider->title}}</h5></td>
                               
                              
                                <td class="text-center">
                                    <h5>
                                          @if($slider->active_flag ==1) Active @elseif($slider->active_flag == 0) Inactive @endif
                                    </h5>
                                </td>
                                <td class="text-center"><h5>{{date('d-m-Y',strtotime($slider->from_date)) }}</h5></td>
                                   <td class="text-center"><h5>{{date('d-m-Y',strtotime($slider->to_date)) }}</h5></td>
                                <td class="text-right">
                                    
                                    <a class="btn btn-sm btn-success" href="{{ url('sliders/reactivate', $slider->id) }}">
                                         Active ?
                                    </a>

                                    <a class="btn btn-sm btn-primary" href="{{ route('sliders.show', $slider->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-info" href="{{ route('sliders.edit', $slider->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                {!! $sliders->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>

@endsection
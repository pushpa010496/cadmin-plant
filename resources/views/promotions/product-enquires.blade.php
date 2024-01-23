@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
             <div class="page-header clearfix">

              <!-- <div class="col-md-8">
              </div> -->
                {{-- <h3>
                     Company
                      <a class="btn btn-info pull-right" style="margin-left: 10px;" href="{{ url('company-history') }}"><i class="fa fa-filter" aria-hidden="true"></i> Filter</a>

                    <a class="btn btn-success pull-right" href="{{ route('companies.create') }}">
                      &nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i> Create</a>
                </h3>                --}}
            </div>
             <div class="col-md-12">
                {!! Form::open(['method'=>'GET','url'=>'product-enquires','role'=>'search'])  !!}
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
            @if($enquires->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5>Produc Name</h5></th>                           
                            <th><h5>Company Name</h5></th>
                            <th><h5>Count</h5></th>
                            <th><h5>Page</h5></th>
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($enquires as $value)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->prod_name}}</h5></td>
                                <td><h5>{{\App\Company::find($value->company_id)->comp_name}}</h5></td>
                                <td class="text-center">{{$value->total}}</td>
                                <td class="text-center">{{$value->page}}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('product-enquires.view', $value->product_id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                </td>
                            </tr><?php $i++; ?>
                             
                        @endforeach
                    </tbody>
                </table>
                {!! $enquires->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
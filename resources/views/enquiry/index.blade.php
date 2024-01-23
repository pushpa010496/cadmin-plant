@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Company Enquiries
                    <a href="{{ route('company.exportalldata') }}" class="btn btn-primary pull-right">  Export All data </a>             
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'company-enquiries','role'=>'search'])  !!}
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
            @if($companies->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5>company Name</h5></th>                           
                            <th><h5> Profiles</h5></th>                           
                            <th><h5>Status</h5></th>  
                            <th><h5>Type</h5></th>  

                            <th><h5>Enquiries</h5></th>
                                
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($companies as $value)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->comp_name}}</h5></td>
                                <td><h5>
                                   @if ($value->companyprofile->count() > 0)
                                      <ul>
                                      @foreach ($value->companyprofile->where('active_flag',1) as $cp)
                                        <li>{{ $cp->title }}</li>
                                      @endforeach
                                      </ul>
                                    @else
                                    <p>
                                     You haven't Profiles. 
                                    @endif
                                </p></td>
                                <td><h5>{{$value->active_flag == 1 ? 'Active':'In Active'}}</h5></td>
                                <td><h5>{{$value->profile_type}}</h5></td>
                                <td> <a href="{{ route('company.exportdata',$value->id) }}">  {{ @$value->enquiries()->count() }} </a></td>
                               
                                
                                <td class="text-right">
                                                                       
                                    <a class="btn btn-sm btn-primary" href="{{ route('company.enquiry.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                                                     
                                 
                                </td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
                {!! $companies->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
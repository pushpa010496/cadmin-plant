@extends('../layouts/app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
           <div class="page-header clearfix">
            <h3 class=" pull-left"> Enquiries for {{ $company->comp_name}} </h3>  
            <a href="{{ route('company.exportdata', $company->id) }}" class="btn btn-primary pull-right">  Export data </a>             
        </div>        
        </div>
       
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            @if($company->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5>Page</h5></th>                           
                                    
                            <th><h5>product</h5></th>  
                            <th><h5>Name</h5></th>
                            <th><h5>Title</h5></th>
                            <th><h5>Email</h5></th>
                            <th><h5>Company</h5></th>
                            <th><h5>Country</h5></th>
                            <th><h5>phone</h5></th>
                            <th><h5>Message</h5></th>
                            <th><h5>Date</h5></th>                                                        
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($company->enquiries as $value)
              
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->page}}</h5></td>
                                
                                <td>{{ @$value->product->title }}</td>
                                <td><h5>{{$value->name}}</h5></td>
                                <td><h5>{{$value->title}}</h5></td>
                                <td><h5>{{$value->email}}</h5></td>
                                <td><h5>{{$value->company}}</h5></td>
                                <td><h5>{{$value->country}}</h5></td>
                                <td><h5>{{$value->phone}}</h5></td>
                                <td><h5>{{$value->message}}</h5></td>
                                <td><h5>{{$value->created_at->format('d/M/Y H:i:s')}}</h5></td>
                               
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
     
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
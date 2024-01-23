@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>company / Show #{{$company->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-link" href="{{ route('companies.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('companies.edit', $company->id) }}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

  <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
               <h5><i class="company icon"></i>company Name</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->comp_name }}</h5>
             </div> 
             <div class="col-md-6">
               <h5><i class="company icon"></i>contact Name</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->contact_name }}</h5>
             </div> 
             <div class="col-md-6">
               <h5><i class="company icon"></i>Email</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->email }}</h5>
             </div> 

              <div class="col-md-6">
               <h5><i class="company icon"></i>phone</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->phone }}</h5>
             </div> 
             <div class="col-md-6">
               <h5><i class="company icon"></i>start date</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->start_date }}</h5>
             </div> 
             <div class="col-md-6">
               <h5><i class="company icon"></i>end date</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->end_date }}</h5>
             </div> 

             <div class="col-md-6">
               <h5><i class="company icon"></i>country</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->country }}</h5>
             </div> 

             <div class="col-md-6">
               <h5><i class="company icon"></i>website</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->website }}</h5>
             </div> 


              <div class="col-md-6">
               <h5><i class="company icon"></i>Product URL</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->product_url }}</h5>
             </div> 

              <div class="col-md-6">
               <h5><i class="company icon"></i>Linkedin URL</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->linkedin }}</h5>
             </div> 

               <div class="col-md-6">
               <h5><i class="company icon"></i>Twitter URL</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->twitter }}</h5>
             </div>  

             <div class="col-md-6">
              <h5><i class="company icon"></i>Faceboob URL</h5>
             </div>
             <div class="col-md-6">
              <h5>{{ $company->facebook }}</h5>
            </div>  


             <div class="col-md-6">
               <h5><i class="company icon"></i>fax</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $company->fax }}</h5>
             </div> 

             <div class="col-md-6">
               <h5><i class="company icon"></i>company Image</h5>
            </div>
            <div class="col-md-6">
                 <h5> 
                  <img src="{{config('app.url')}}suppliers/{{str_slug($company->comp_name)}}/{{$company->comp_logo}}">
                 </h5>
             </div>  

             <div class="col-md-6">
               <h5><i class="company icon"></i>Address</h5>
            </div>
            <div class="col-md-6">
                  <h5>{!! $company->address!!}</h5>
             </div>  

             <div class="col-md-6">
              <h5><i class="company icon"></i>company Bannere</h5>
             </div>
             <div class="col-md-6">
               <h5> 
                <img src="{{config('app.url')}}suppliers/{{str_slug($company->comp_name)}}/{{$company->banner_image}}">
              </h5>
            </div>  

        </div>
    </div>

@endsection

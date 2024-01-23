@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>subCategory / Show #{{$subcategory->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-link" href="{{ route('categories.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('categories.edit', $subcategory->id) }}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

  <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
               <h5><i class="subcategory icon"></i>subCategory Name</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $subcategory->subcat_name }}</h5>
             </div>  

             <div class="col-md-6">
               <h5><i class="subcategory icon"></i>subCategory Image</h5>
            </div>
            <div class="col-md-6">
                 <h5> <img width="200" src="{{config('app.url')}}subcategory/{{$subcategory->subcat_img}}" /></h5>
             </div>  

             <div class="col-md-6">
               <h5><i class="subcategory icon"></i>Short Description</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $subcategory->subcat_des }}</h5>
             </div>  

        </div>
    </div>

@endsection

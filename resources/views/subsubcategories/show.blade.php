@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>subsubCategory / Show #{{$subsubcategory->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-link" href="{{ route('subsubcategories.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>
            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('subsubcategories.edit', $subsubcategory->id) }}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

  <div class="well well-sm col-md-offset-3 col-md-6">
        <div class="row">
            <div class="col-md-6">
               <h5><i class="subsubcategory icon"></i>subsubCategory Name</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $subsubcategory->subsubcat_name }}</h5>
             </div>  

             <div class="col-md-6">
               <h5><i class="subsubcategory icon"></i>subsubCategory Image</h5>
            </div>
            <div class="col-md-6">
                 <h5> <img width="200" src="{{ asset('../industry/subsubcategory/'.$subsubcategory->subsubcat_img) }}" /></h5>
             </div>  

             <div class="col-md-6">
               <h5><i class="subsubcategory icon"></i>Short Description</h5>
            </div>
            <div class="col-md-6">
                  <h5>{{ $subsubcategory->subsubcat_des }}</h5>
             </div>  

        </div>
    </div>

@endsection

@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>Role / Show #{{$role->id}}</h3>
    </div>
@endsection

@section('content')
    
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('roles.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('roles.edit', $role->id) }}">
                   <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <div class="well well-sm">
        <div class="row">
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i>Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $role->name }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="role icon"></i>Display Name</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $role->display_name }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="role icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $role->description }}</h5>
              </div>
       </div>
    </div>

@endsection

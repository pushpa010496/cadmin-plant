@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i>  User
            <a class="btn btn-sm btn-success pull-right" href="{{ route('users.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
        </h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
          {!! Form::open(['method'=>'GET','url'=>'users','role'=>'search'])  !!}
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
        <br><br>
        <div class="col-md-12">
            @if($users->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th> <th>Email</th> 
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center"><strong>{{$i}}</strong></td>

                                <td>{{$user->name}}</td> <td>{{$user->email}}</td> 
                                
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('users.show', $user->id) }}">
                                      
                                      <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-info" href="{{ route('users.edit', $user->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                {!! $users->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>

@endsection
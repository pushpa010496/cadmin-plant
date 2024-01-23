@extends('../layouts/app')

@section('header')
    <div class="page-header"> 
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  User / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <form action="{{ route('users.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control']) }}
                </div>
                 
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('email', 'email', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password:') !!}
                    {{ Form::input('password', 'password', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password:') !!}
                    {{ Form::input('password','password_confirmation', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) }} 
                </div>
                 <div class="form-group">
                    {!! Form::label('roles', 'Roles:') !!}
                    {!! Form::select('roles', $roles, null,['id'=>'','class' => 'form-control','placeholder'=>'Select a Role'] ) !!}
                </div>
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
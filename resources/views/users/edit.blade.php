@extends('../layouts/app')

@section('header')
    
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="page-header">
                <h3><i class="glyphicon glyphicon-edit"></i> User / Edit #{{$user->id}}</h3>
            </div> 
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', old('name', $user->name ), ['class' => 'form-control']) }}
                </div>
                 
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {{ Form::input('email', 'email', old('email', $user->email ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Old Password:') !!}
                    {{ Form::input('password', 'old_password', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'New Password:') !!}
                    {{ Form::input('password', 'password', null, ['class' => 'form-control']) }}
                </div>
                
                 <div class="form-group">
                    {!! Form::label('roles', 'Role:') !!}
                    {!! Form::select('roles', $roles, $user->roles->pluck('id')->toArray(),['id'=>'','class' => 'form-control','placeholder'=>'Select a Role'] ) !!}
                </div>              

                <div class="well well-sm">
                    <button type="submit" name="submit_user" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>

        <!-- <div class="col-md-6">
             <div class="page-header">
                <h3><i class="glyphicon glyphicon-edit"></i> Change Password</h3>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                <div class="form-group">
                    {!! Form::label('password', 'Password:') !!}
                    {{ Form::input('password', 'password', null, ['class' => 'form-control']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password:') !!}
                    {{ Form::input('password','password_confirmation', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) }} 
                </div>
                <div class="well well-sm">
                    <button type="submit" name="submit_pass" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div> -->


    </div>
@endsection
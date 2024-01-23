@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i>Select Table from your Data Base
            <!-- <a class="btn btn-sm btn-success pull-right" href="{{ route('cmspages.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Create</a> -->
        </h3>
    </div>

@endsection

@section('content')
   <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('url' => 'dataexport','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('Database', 'Database:') !!}
                    {{-- {{ Form::input('text', 'database', null, ['class' => 'form-control','required'=>'required']) }} --}}

                      <select name="database" id="database" class="form-control">
                        <option value="">-- Select one --</option>
                        <option value="plantaut_laravel">Plant</option>
                        <option value="packagin_laravel">Packagin</option>
                        <option value="defencei_laravel">Defence</option>
                            
                    </select> 

                    {!! Form::label('Database user', 'User Key:') !!}
                     <select name="databaseuser" id="databaseuser" class="form-control">
                        <option value="">-- Select one --</option>
                        <option value="plantaut_plslara">Plant</option>
                        <option value="packagin_larause">Packagin</option>
                        <option value="defencei_larause">Defence</option>
                            
                    </select> 

                    {!! Form::label('Export', 'Security Key:') !!}
                      <select name="databaseuserpassword" id="databaseuserpassword" class="form-control" >
                        <option value="AmL76Z^(~bwA">Plant</option>
                        <option value="[WX.Gs*2t9?m">Packagin</option>
                        <option value="Iowj+Gut_S%1">Defence</option>
                            
                    </select> 
                    
                </div>
               
               
              
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Connect Database</button>
                   <!--  <a class="btn btn-sm btn-default pull-right" href="{{ route('cmspages.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> -->
                </div>
            </form>

        </div>
    </div>
@endsection
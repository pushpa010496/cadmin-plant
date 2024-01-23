
@extends('layouts/app')
@section('header')
    
@endsection

@section('content')
    @include('error')



<div class="container col-lg-6">

<div class="panel panel-primary">

 <div class="panel-heading">Your new connection is Success with <?php echo $db; ?> Select The Table</div>

  <div class="panel-body col-lg-6"> 

   {!! Form::open(array('route' => 'export.file','method'=>'POST','files'=>'true')) !!}
                 <input type="hidden" name="db_name" value="{{$db}}">
                  <input type="hidden" name="db_user" value="{{$dbuser}}">
                   <input type="hidden" name="db_password" value="{{$dbpassword}}">
                <div class="form-group">
                 
                    <select name="tableinfo" id="tableinfo" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                      
                         @foreach ($tables as $key => $value)

                        <?php $db_info = 'Tables_in_'.$db; echo $db_name = $value->$db_info;  ?>
                        <option value="{{$db_name}}"> {{$db_name}}</option>
                        @endforeach
                      
                    </select>
                </div>
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Export to excel</button>
                   <!--  <a class="btn btn-sm btn-default pull-right" href="{{ route('cmspages.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> -->
                </div>
            </form>

   </div>     

     


 </div>

</div>

</div>
@endsection

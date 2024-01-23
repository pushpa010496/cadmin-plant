@extends('../layouts/app')

@section('content')

  <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="#"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>

     <div class="well well-sm">
        <div class="row">
           <div class="col-md-offset-3 col-md-6">
<form method="post" action="{{route('position.update')}}">
  {{csrf_field()}}
              <div class="form-group">          
                 {!! Form::label('position1', 'position1:') !!}
                    {{ Form::select('position1', $position_interviews, old('id',@$position_interviews1->id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select position']) }}
               
              </div>
             
            <div class="form-group">          
                 {!! Form::label('position2', 'position2:') !!}
                    {{ Form::select('position2', $position_interviews, old('id',@$position_interviews2->id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select position']) }}
              </div>
           
            <div class="form-group">          
                 {!! Form::label('position3', 'position3:') !!}
                    {{ Form::select('position3', $position_interviews, old('id',@$position_interviews3->id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select position']) }}
              </div>
                <div class="form-group">          
                 {!! Form::label('position4', 'position4:') !!}
                    {{ Form::select('position4', $position_interviews, old('id',@$position_interviews4->id), ['class' => 'form-control','placeholder'=>'Select position']) }}
              </div> 
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('interviews.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>  
 </form>    
       </div>
    </div>
  </div>
@endsection
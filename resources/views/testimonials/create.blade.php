@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Testimonials / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('route' => 'testimonials.store','files'=>true)) !!}
                
                <div class="form-group">
                    {!! Form::label('client_name', 'Client Name:') !!}
                    {{ Form::input('text', 'client_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_name', 'Company Name:') !!}
                    {{ Form::input('text', 'company_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('image', 'Testimonial Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
            
                <div class="form-group">
                    {!! Form::label('img_title', 'testimonial Img Title:') !!}
                    {{ Form::input('text', 'img_title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'testimonial Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('designation', 'Designation:') !!}
                    {{ Form::input('text', 'designation', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null, ['class' => 'form-control','size'=>'30x4']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('adv_description', 'Adv Description:') !!}
                    {{ Form::textarea('adv_description', null, ['class' => 'form-control','size'=>'30x4']) }}
                </div>
              
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('testimonials.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

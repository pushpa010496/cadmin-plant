@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Partners / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
                 {!! Form::open(array('route' => 'partners.store','files'=>true)) !!}
                
                <div class="form-group">
                    {!! Form::label('type', 'Type:') !!}                    
                    <select name="type" class="form-control">
                        <option value="">Select</option>
                        <option value="1">Online Partners</option>
                        <option value="2">Media Partners</option>
                        <option value="3">Group Partners</option>
                        <option value="4">Association Partners</option>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'partner Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('partner_url', 'partner Url:') !!}
                    {{ Form::input('text', 'partner_url', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('partner_url_active', 'Active Profile Redirect:') !!}
                    
                    <input type="radio" id="smt-fld-1-2" name="optradio1" value="1">Yes</label>
                  
                    <input type="radio" id="smt-fld-1-3" name="optradio1" value="0">No</label>
                    
                </div>
                 <div class="form-group">
                    {!! Form::label('partner_image', 'partner Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                </div>
            
                <div class="form-group">
                    {!! Form::label('img_title', 'Partner Img Title:') !!}
                    {{ Form::input('text', 'img_title', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('img_alt', 'Partner Img Alt:') !!}
                    {{ Form::input('text', 'img_alt', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {!! Form::label('home_logo', 'Home Logo:') !!}
                     {!! Form::file('home_logo', array('class' => '')) !!}
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
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('partners.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

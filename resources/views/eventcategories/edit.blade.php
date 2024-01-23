@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> Event Category / Edit #{{$eventcategory->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
         <div class="col-md-offset-3 col-md-6">
            <form action="{{ route('event-categories.update', $eventcategory->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {{ Form::input('text', 'name', old('name', $eventcategory->name ), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', 'Parent:') !!}
                   {!! \App\EventCategory::attr(['name' => 'parent_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($eventcategory->parent_id)
                   ->renderAsDropdown() !!}
                </div>
                <div class="form-group">
                    {!! Form::label('image', 'Category Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                     @if($eventcategory->image)<img width="200" src="{{config('app.url')}}eventcategory/{{$category->image}}" />
                     @endif
                </div>         
                
                <div class="form-group">
                <label for="short_description-field">eventcategory Description</label>
                <textarea name="short_description" class="form-control" rows="5">{{ old('short_description', $eventcategory->short_description ) }}</textarea>
                </div> 
                
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('event-categories.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

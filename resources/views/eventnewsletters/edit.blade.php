@extends('../layouts/app')

@section('header')
    <div class="page-header">
        <h3><i class="fa fa-pencil-square" aria-hidden="true"></i> Event Newsletter  / Edit </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            
            <form action="{{ route('eventnewsletters.update', $newsletter->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {!! Form::label('title', 'newsletter Title:') !!}
                    {{ Form::input('text', 'title', old('title', $newsletter->title), ['class' => 'form-control','required'=>'required']) }}
                </div>
               
                 <div class="form-group">
                    {!! Form::label('file', 'newsletter File:') !!}
                     {!! Form::file('file', array('class' => '')) !!}
                     @if($newsletter->file)
                    <a href="<?php echo config('app.url'); ?>events-newsletters/<?php echo $newsletter->file;?>">View file</a>
                    @endif
                </div>

                  <div class="form-group">
                    {!! Form::label('image', 'newsletter Image:') !!}
                     {!! Form::file('image', array('class' => '')) !!}
                     @if($newsletter->image)
                    <a href="<?php echo config('app.url'); ?>events-newsletters/images/<?php echo $newsletter->image;?>">View file</a>
                    @endif
                </div>
               
                <div class="form-group">
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($newsletter->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($newsletter->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('eventnewsletters.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
            </form>
       
        </div>
    </div>
@endsection

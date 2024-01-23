
   
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">
      {!! Form::open(array('route' => 'tags.store','files'=>true)) !!}
                  <input type="hidden" name="category_id" value="{{$value->category_id}}">
                <div class="form-group">
                  <!--    @php
                        $category_list=App\Category::where('active_flag',1)->where('parent_id','!=','22')->pluck('name','id');
                                    
                    @endphp
                    {!! Form::label('category_id', 'Categories:') !!}
                    {{ Form::select('category_id', $category_list, null, ['class' => 'form-control','id'=>'','required'=>'required','placeholder'=>'Select Company']) }} -->
                </div>
                <div class="form-group">
                    {!! Form::label('tag_name', 'Tag name:') !!}
                    {{ Form::input('text','tag_name', null, ['class' => 'form-control','id'=>'tag_name','required'=>'required']) }}
                </div>
                
            @if(session()->has('message'))
                <p class="error">
                    {{ session()->get('message') }}
                </p>
            @endif 
           
              <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary" id="test">Create</button>
                   <!--  <a class="btn btn-sm btn-default pull-right" href="{{ route('tags.index') }}"><i class="fa fa-arrow-left"></i> Back</a> -->
                </div>  
          
               
            </form>
        </div>
    </div>

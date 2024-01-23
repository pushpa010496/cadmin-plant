
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'subtags.store','files'=>true)) !!}
              <input type="hidden" name="ajax_id" id="ajax_id"  value="{{$value->id}}">
                  <input type="hidden" name="category_id" id="category_id"  value="{{$value->category_id}}" data-dataca="{{$value->category_id}}">
       
                
                
@php
                       $tags=App\Tags::where('active_flag',1)->where('category_id',$value->category_id)->get();
                    @endphp
               
                   <!--  {!! Form::label('tag_id', 'Tag:') !!}
                    {{ Form::select('tag_id', $tags, null, ['class' => 'form-control','id' =>'tags','required'=>'required','placeholder'=>'Select Tag']) }} -->

                    <div class="form-group">
                  <select class="form-control" name="tag_id" id="tag_id">
                     
                    <option value="och" data-datac="och">Select Tag*</option>
                   
                   @foreach($tags as $tag)
                    <option value="{{$tag->id}}" data-datac="{{$tag->id}}">{{$tag->tag_name}}</option>
                
                    @endforeach 
                  </select>
               
                </div>
                <div class="">
                  <p class="checkerror" style="color:#f0ad4e"></p>
                </div>
                 <!--  @if(session()->has('message'))
                <p class="error text-danger" >
                    {{ session()->get('message') }}
                </p>
            @endif  -->
                <div class="form-group">
                    {!! Form::label('subtag_name', 'Subtag Name:') !!}
                    {{ Form::input('text', 'subtag_name', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                      
           
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                 
                </div>  
          
               
            </form>
        </div>
    </div>


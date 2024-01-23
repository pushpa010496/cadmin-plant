@extends('../layouts/app')

@section('style')
<style type="text/css">
  *,
*:before,
*:after {
    -webkit-box-sizing: border-box; 
    -moz-box-sizing: border-box; 
    box-sizing: border-box;
}

#integration-list {
    font-family: 'Open Sans', sans-serif;
    width: 100%;
    margin: 0 auto;
    display: table;
}
#integration-list ul {
    padding: 0;
    margin: 20px 0;
    color: #555;
    background-color: #fff;
}
#integration-list ul > li {
    list-style: none;
    border-top: 1px solid #ddd;
    display: block;
    padding: 15px;
    overflow: hidden;
    background: #ccc;
}
#integration-list ul:last-child {
    border-bottom: 1px solid #ddd;
}
#integration-list ul > li:hover {
    background: #ccc;
}
.expand {
    display: block;
    text-decoration: none;
    color: #555;
    cursor: pointer;
}
h2 {
    padding: 0;
    margin: 0;
    font-size: 17px;
    font-weight: 400;
}
span {
    font-size: 12.5px;
}
#left,#right{
    display: table;
}
#sup{
    display: table-cell;
    vertical-align: middle;
    width: 80%;
}
.detail a {
    text-decoration: none;
    color: #C0392B;
    border: 1px solid #C0392B;
    padding: 6px 10px 5px;
    font-size: 14px;
}
.detail { 
  display: none;
  /*  margin: 10px 0 10px 0px;
   
    line-height: 22px;
    height: 150px;*/
}
.detail span{
    margin: 0;
}
/*.right-arrow {
    margin-top: 12px;
    margin-left: 20px;
    width: 10px;
    height: 100%;
    float: right;
    font-weight: bold;
    font-size: 20px;
}*/
.icon {
    height: 75px;
    width: 75px;
    float: left;
    margin: 0 15px 0 0;
}
.london {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
.newyork {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
.paris {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
.ms-res-ctn .ms-res-item {
    color: #fff;
}
.ms-res-ctn .ms-res-item-active {
    background-color: #000;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: solid black 1px;
    outline: 0;
    color: #000;
}
.select2-container--default .select2-results>.select2-results__options {
    max-height: 200px;
    overflow-y: auto;
    color: #000;
}
</style>
@endsection
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Products / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'store_product_landingpages','files'=>true)) !!}

                <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null,
                     ['class' => 'form-control my-editor']) }}
                </div>
  
                <div class="form-group"  >
                   <!-- <select name="product_id[]" id="product_id"  class="form-control" required multiple>
                    <option value="">Select Products</option>
                    @foreach($products as $product)
                      <option value="{{$product->id}}">{{$product->title}}</option>
                    @endforeach
                  
                  </select> -->

                  <label for="select2Multiple">Select Products</label>
              <select class="select2-multiple form-control text-black" name="product_id[]" multiple="multiple"
                id="select2Multiple">
               
                @foreach($products as $product)

                <option value="{{$product->id}}" style='color:#000;'>{{$product->title}}</option>  
               @endforeach
              </select>
 
                </div>
                
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('url', 'slug:') !!}
                    {{ Form::input('text', 'url', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <!-- <div class="form-group">
                  {!! Form::label('stage', 'Stage:') !!}
                  <select name="stage" class="form-control" required="required">
                    <option value="">-- Select one --</option>
                    <option value="1">Live</option>
                    <option value="0">Test</option>
                  </select>
                </div> -->
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('product_landingpages') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>  
          
               
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('textarea.my-editor').ckeditor();
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        $(document).ready(function() {
            // Select2 Multiple

            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
              
            });

        });

    </script>
@endsection
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
        <h3> Product Landingpage / Edit #{{$product_landingpages->id}} </h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-3 col-md-8 col-md-offset-3">

            <form action="{{ route('update_product_landingpages', $product_landingpages->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

             {!! Form::open(array('route' => 'store_product_landingpages','files'=>true)) !!}
                
                <div class="form-group">
                    {!! Form::label('title', ' Title:') !!}
                    {{ Form::input('text', 'title', old('title',$product_landingpages->title), ['class' => 'form-control','required'=>'required']) }}
                </div>

                
                 
               
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$product_landingpages->description),
                     ['class' => 'form-control my-editor']) }}
                </div>
                       
                <div class="form-group">
                    
                   <!--<select name="product_id[]" id="" multiple class="form-control"  required>-->
                   <!-- <option value="">Select Products</option>-->
                    {{ Form::select('product_id[]', $products->pluck('title','id'), explode(',',$product_landingpages->products_id), ['class' => ' select2-multiple form-control','multiple'=>'multiple','placeholder'=>'Select supplier alphabets']) }}
                    <!--@foreach($products as $product)-->
                    <!--  <option value="{{$product->id}}"  @if($product->id==$product_landingpages->products_id) selected='selected' @endif >{{$product->title}}</option>-->
                    <!--@endforeach-->
                  
                  <!--</select>-->
                </div>
                <!-- value for edit option -->
 

                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}

                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($product_landingpages->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($product_landingpages->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('url', 'slug:') !!}
                    {{ Form::input('text', 'url', old('url',$product_landingpages->url), ['class' => 'form-control','required'=>'required']) }}
                </div> 

                <!-- <div class="form-group">
                  {!! Form::label('stage', 'Stage:') !!}

                  <select name="stage" class="form-control" required="required">
                    <option value="">-- Select one --</option>
                    @if($product_landingpages->stage == 1)
                    <option value="1" selected="selected">Live</option>
                    <option value="0">Test</option>
                    @elseif($product_landingpages->stage == 0)
                    <option value="1">Live</option>
                    <option value="0" selected="selected">Test</option>
                    @endif
                  </select>
                </div>       -->
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    
                     <a class="btn btn-sm btn-default pull-right" href="{{ route('product_landingpages') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
<script>
     var options = {
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("article")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Files',
    filebrowserUploadUrl: '{{public_path("article")}}/?type=Files&_token='
    };
  $('textarea.my-editor').ckeditor(options);
</script>


<script type="text/javascript">
  $("select[name='company_id']").change(function(){
      var company_id = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo url('select-ajax') ?>",
          method: 'GET',
          data: {company_id:company_id, _token:token},
          success: function(data) {
            $("select[name='company_profile_id'").html('');
            $("select[name='company_profile_id'").html(data.options);
          }
      });
  });

  $(function() {
  $(".expand").on( "click", function() {
    $(this).next().slideToggle(200);
    $expand = $(this).find(">:first-child");
    
    if($expand.text() == "+") {
      $expand.text("-");
    } else {
      $expand.text("+");
    }
  });
});
   $("select[id='catid']").change(function(){
      var catid = $(this).val();

      $.get('{{url("/")}}/ajax-cate/'+catid,function(data) {

            $("#subcatid").empty().append(data);      
       });
      });
  
</script>
<!--<script>-->
<!--$(function() {-->
<!--        var ms1 = $('#ms1').magicSuggest({-->
            // loop through $products and add them to the dataSource
<!--            data: [-->
<!--                @foreach($products as $product)-->
<!--                '{{$product->title .= ' - ' . $product->id}}',-->
<!--                @endforeach-->
<!--            ]-->
<!--        });-->
<!--      });-->
<!--</script>-->
<!--<script>-->
<!--    window.addEventListener('change', function (e) {-->
<!--        let x = document.getElementsByClassName('ms-sel-item')-->
<!--        let y = document.getElementsByClassName('ms-res-item')-->
<!--        Array.from(y).forEach(function(element) {-->
<!--            element.addEventListener('click', function(e) {-->
<!--                document.getElementById('selected_options').value += element.innerText.split(' - ')[1] + ','-->
<!--            }-->
<!--            )-->
<!--        }-->
<!--        )-->
<!--    }-->
<!--    )-->


<!--    </script>-->
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
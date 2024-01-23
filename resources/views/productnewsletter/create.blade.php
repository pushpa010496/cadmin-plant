@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>News Letters Live Link/ Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
    
        <div class="col-md-offset-1 col-md-10">
          {!! Form::open(array('route' => 'productnewsletter.store','files'=>true)) !!}
            <div class="col-md-6">
              
                <div class="form-group">
                    {!! Form::label('category', 'Category:') !!}
                    <select name="category" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="articles">Product Newsletter</option>
                       

                        
                    </select>
                </div>

                <!--  <div class="form-group">
                    {!! Form::label('Image Title', 'Image title:') !!}
                       {{ Form::text('imgtitle', null, ['class' => 'form-control']) }}
                </div> -->
                 <br>
                 
                <div class="row form-group">
                    {!! Form::label('image', 'Upload Image:',['class' => 'col-md-3']) !!}
                    {{ Form::file('image', null, ['class' => 'form-control col-md-9']) }}
                </div>

                 <br>

                <div class="form-group">
                  <input type="submit" id="sub" name="sub" class="btn btn-success" value="Generate Link">
                </div>
            </div>
                
          </form>

          <div class="clearfix"></div>

          <br>

           @if(@$livelinkexists)
           <h4 class="text-warning"><i class="fa fa-lg fa-exclamation-triangle"></i> File Already Exists <small>Please change image name</small></h4>
           
            <img src="{{$livelinkexists}}" style="width: 200px;padding-top: 20px;">

            @endif
            
          @if(@$livelink)
          <div id="alert" class="form-group">
            <div class="col-md-10">
              <input type="text" value="{{$livelink}}" id="myInput" class="form-control">  
            </div>
            <div class="col-md-2">
              <button onclick="myFunction()" class="btn btn-info">
                <i class="fa fa-clipboard" aria-hidden="true"></i> Copy Link
              </button>
            </div>
          </div>
          @endif
           

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
 
</script>

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  $("#copyalert").html("Copied");
  //location.reload(true);
  // $("#alert").remove();

    $("#alert").html("Link Copied");
 }

$("#sub").click(function(){



 var image=$("#image").val();



 if(image!=""){

return true;

 }
 else{

  alert("Please select image file");
  return false;
 }

})
 
</script>

@endsection
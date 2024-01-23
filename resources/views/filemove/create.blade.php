@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
    
        <div class="col-md-offset-1 col-md-10">
          {!! Form::open(array('route' => 'move-file.store','files'=>true)) !!}
            <div class="col-md-6">
              
                <div class="form-group">
                    {!! Form::label('Company', 'Company:') !!}
                   {{ Form::text('company', null, ['class' => 'form-control col-md-9']) }}
                </div>

               
                 <br>
                 
               <br>

               
                  <input type="submit" id="sub" name="sub" class="btn btn-success" value="create folder">
              
            </div>
                
          </form>

         
    </div>

    <div class="row">
    
      {{--  <div class="col-md-offset-1 col-md-10">
          {!! Form::open(array('route' => 'event-indexing.store','files'=>true)) !!}
           <br>

           <br>
                  <input type="submit" id="sub" name="sub" class="btn btn-success" value="Event Indexing">
              
            </div>
                
          </form> 

         
    </div>--}}
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
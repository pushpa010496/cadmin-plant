@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> {{$msg['title']}} </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
    
        <div class="col-md-offset-1 col-md-10">

           <div class="alert alert-info">
            <strong>info!</strong> {{$msg['info']}}<br>
            <strong>Note :</strong> {{$msg['note']}}.
          </div>
          {!! Form::open(array('route' => $msg['post_route'],'files'=>true)) !!}
            <div class="col-md-6">                                             
                <div class="row form-group">
                    {!! Form::label('sample_file', 'Upload File:',['class' => 'col-md-3']) !!}
                    {{ Form::file('sample_file', null, ['class' => 'form-control col-md-9']) }}
                </div>

                 <br>

                <div class="form-group">
                  <input type="submit" id="sub" name="sub" class="btn btn-success" value="Move Profiles">
                </div>
            </div>
                
          </form>

          <div class="clearfix"></div>

         
            
         
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
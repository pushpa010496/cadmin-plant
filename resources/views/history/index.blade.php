@extends('../layouts/app')
@section('content')
<style type="text/css">


.mytext{
    border:0;padding:10px;background:whitesmoke;
}
.text{
    width:75%;display:flex;flex-direction:column;
}
.text > p:first-of-type{
    width:100%;margin-top:0;margin-bottom:auto;line-height: 13px;font-size: 12px;
}
.text > p:last-of-type{
    width:100%;text-align:right;color:silver;margin-bottom:-7px;margin-top:auto;
}
.text-l{
    float:left;padding-right:10px;
}        
.text-r{
    float:right;padding-left:10px;
}
.avatar{
    display:flex;
    justify-content:center;
    align-items:center;
    width:25%;
    float:left;
    padding-right:10px;
}
.macro{
    margin-top:5px;width:85%;border-radius:5px;padding:5px;display:flex;
}
.msj-rta{
    float:right;background:whitesmoke;
}
.msj{
    float:left;background:white;
}
.frame{
    background:#e0e0de;
    height:450px;
    overflow:hidden;
    padding:0;
}
.frame > div:last-of-type{
    position:absolute;bottom:0;width:100%;display:flex;
}



/*ul {
    width:100%;
    list-style-type: none;
    padding:18px;
    position:absolute;
    bottom:47px;
    display:flex;
    flex-direction: column;
    top:0;
    overflow-y:scroll;
}*/

.chat-box {
  position: fixed;
  background: #ccc;
  right: 0;
  bottom: 0;
  padding: 20px;
}
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
</style>
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Company History
                  {{--   <a href="{{ route('company.exportalldata') }}" class="btn btn-primary pull-right">  Export All data </a>   --}}           
                </h3>               
            </div>
            <div class="row">
             <div class="col-md-4">
          {!! Form::open(['method'=>'GET','url'=>'company-history','role'=>'search'])  !!}
              <div id="custom-search-input">
                <div class="input-group col-md-12 pull-right">
                    <input type="text" class="search-query form-control" placeholder="Search" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>

                        </button>
                    </span>
                </div>
              </div>
         {!! Form::close() !!}
        </div>
     
        <div class="col-md-2">
             <div class="form-group">
                    <select name="active_flag" class="form-control" required="required" id="mySelect">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
              </div>

                

 <div class="col-md-2">
             <div class="form-group">
                   <select name="profile_type" class="form-control" required="required" id="profile_stage">
                    <option value="">-- Select Profile type --</option>
                    <option value="blind">Blind</option>
                    <option value="free">Free</option>
                     <option value="paid">Paid</option>
                  </select>
                </div>
              </div>

  <div class="col-md-2">
                 
                    {{ Form::input('text', 'from_date', null, ['class' => 'form-control datepicker','required'=>'required','id'=>'from_date','placeholder'=>'From Date','autocomplete'=>'off']) }}
                </div>
                <div class="col-md-2">
                  
                    {{ Form::input('text', 'to_date', null, ['class' => 'form-control datepicker','required'=>'required','id'=>'to_date','placeholder'=>'To Date','autocomplete'=>'off']) }}
                </div>

              
              </div>
        </div>


    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            @if($companies->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><h5>#</h5></th>
                            <th><h5>company Name</h5></th>                       
                            <th><h5>Status</h5></th>  
                            <th><h5>Type</h5></th>  
                            <th><h5>End Date</h5></th>  
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>
<tbody id="statusresult"><tr><td></td></tr></tbody>
                    <tbody id="statusresultnon">

                      <?php $i=1; ?>
                        @foreach($companies as $value)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->comp_name}}</h5></td>
                              
                                <td><h5>{{$value->active_flag == 1 ? 'Active':'In Active'}}</h5></td>
                                <td><h5>{{$value->profile_type}}</h5></td>
                              
                               <td><h5>{{$value->end_date}}</h5></td>
                                
                                <td class="text-right">
                                                                       
                                    <a class="btn btn-sm btn-primary" href="{{ route('company.history.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                       <input type="hidden" name="getcompany_id" id="getcompany_id" value="{{$value->id}}">                       
                                 <a class="btn btn-sm btn-primary ajaxbtn" data-datac="{{$value->id}}" onclick="openForm();"> Comment</a>
                                </td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
             
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

        <div class="col-sm-3  frame chat-box chat-popup" id="myForm">
          <div style="background-color:#92278f;min-height:19px;margin:-18px">
            <button class="close" onclick="document.getElementById('myForm').style.display='none'" ><i class="fa fa-times text-info" aria-hidden="true" ></i></button>
          
          </div>

         <ul ui-scroll-viewport style="overflow-y: scroll; height: 350px;margin: 20px;margin-left: -40px;
    margin-right: -14px;"  class="ulinfo" id="ulinfo">
            {{-- <li style="width:100%"><div class="msj macro"><div class="avatar"><img class="img-circle" style="width:100%;" src="https://www.ochre-media.com/images/logo.png"></div><div class="text text-l" id="result" > <p ></p><p><small>3:20 PM</small></p></div></div></li> --}}

 

         </ul>
      
      {{--   <div  id="testget"> --}}
             
        
                
                <div class="">

                      
                       <div class="container">
                           
                            <div class="form-inline"><span style=" height: 30px;">
                               
                                <input class="mytext" placeholder="Type a message" id="description" name="description">
                                 <button class="chatinfo" id="users" name="users"> <i class="fa fa-2x fa-share text-primary"></i></button>
                                  <input type="hidden" name="company_id" id="company_id" value="">  
                                 </span>
                            </div>
                        </div>                  
                            <!--                 <div class="text text-r form-inline style="background:whitesmoke !important">
                        
                        <input class="mytext" placeholder="Type a message" name="description" /><span style="margin:left;">
                      <button type="submit" id="users" name="users"> <i class="fa fa-2x fa-share text-primary"></i></button>  
                  
                  
                   </span>
                    <div class="avatar">
                     <img class="img-circle" style="width:100%" src="https://www.ochre-media.com/images/logo.png">
                     </div>
                    </div>  -->
                      
               

                </div>
              
              
                              
            </div>
            

        </div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>


   $('.datepicker').datepicker({dateFormat: "yy-mm-dd",
      onSelect: function (dateText, inst) {

        var from =$("#from_date").val();
        $('#statusresultnon').hide();
        var to =$("#to_date").val();
        var url = "{{ url('profileexpire') }}"

       

      if(from==''){
alert("please select From Date");
//$("#from_date").focus();

       }

       if(to==''){
alert("please select To date");
//$("#to_date").focus();


       }
        $.ajax({
           
          url: url + '/',
          type: 'get',
          data : {from_date:from, to_date :to },
          dataType: 'json',
          cache: false,
          success:function(data){
          // alert( JSON. stringify(data));
          var i=1;
          $('#statusresult').empty();
             $.each(data, function( index, value ){
             console.log(JSON. stringify(value));

             var url = '{{ route("company.history.show", ":id") }}';
             url = url.replace(':id', value.id);
/*$('.stocks_list').append('<li><a href="'+url+'">' + stock.symbol + ' </a></li>');*/
var stsres=value.active_flag;
if(stsres==1){

var sts="Active";
}
else
{

var sts="In Active";
}

             $('#statusresult').show();
            
  
$('#statusresult').append("<tr><td>" +i+ "</td><td>"+ value.comp_name + "</td><td>" + sts + "</td><td>" 
  + value.profile_type + "</td><td>" + value.end_date + '</td><td> <a class="btn btn-sm btn-primary" href='+url+'>view</a>&nbsp;<a class="btn btn-sm btn-primary ajaxbtn" data-datac='+value.id+' >Comment</a></td></tr>');

i++;
});
           }
           });


      }
   });

  </script>
<script type="text/javascript">
function openForm() {

}

/*$('.ajaxbtn').on("click", function(){
  alert("success");
});*/

$(document).on('click', '.ajaxbtn', function(){
    var company = $(this).data('datac');     
        
    $('#company_id').val(company);

    document.getElementById("myForm").style.display = "block";  

    var message=$('#description').val();

    console.log(message);


    $("#description").focus();

    var url = "{{ url('getsupportit') }}"
        $.ajax({
           
          url: url + '/' + company ,
          type: 'get',
          dataType: 'json',
          cache: false,
          success:function(data){
           // alert( JSON. stringify(data));
             $.each( data, function( index, value ){
               
        $('.ulinfo').append(`
                        
                         <div class="msj macro" style="width:30;margin-left: 10px;
    margin-right: 14px;">
                    
                     <p style="color:#4682B4">${value.comment}</p>
                    
                     `);
         $("#ulinfo").animate({ scrollTop: $("#ulinfo")[0].scrollHeight},0);

                    }); 


          }


           });



});




/*$('.ajaxbtn').click(function() {

  alert("");
        
        var company = $(this).data('datac');     
        
        console.log(company);

        //alert(company);

      $('#company_id').val(company);

    document.getElementById("myForm").style.display = "block";  

    var message=$('#description').val();

    console.log(message);


    $("#description").focus();
  
    var url = "{{ url('getsupportit') }}"
        $.ajax({
           
          url: url + '/' + company ,
          type: 'get',
          dataType: 'json',
          cache: false,
          success:function(data){
           // alert( JSON. stringify(data));
             $.each( data, function( index, value ){
               
        $('.ulinfo').append(`
                        
                         <div class="msj macro" style="width:30;margin-left: 10px;
    margin-right: 14px;">
                    
                     <p style="color:#4682B4">${value.comment}</p>
                    
                     `);
         $("#ulinfo").animate({ scrollTop: $("#ulinfo")[0].scrollHeight},0);

                    }); 


          }


           });
      

       
} );
*/



   $(document).on('change', '#profile_stage', function(){

// $('#profile_stage').change(function(){ 

   $('#statusresultnon').hide();

    var stage = $(this).val();

    //alert(stage);

 

     var url = "{{ url('profilestage') }}"
        $.ajax({
           
          url: url + '/' +stage,
          type: 'get',
        
          dataType: 'json',
          cache: false,
          success:function(data){
         //alert( JSON. stringify(data));
          var i=1;
          $('#statusresult').empty();
             $.each(data, function( index, value ){
             console.log(JSON. stringify(value));

             var url = '{{ route("company.history.show", ":id") }}';
             url = url.replace(':id', value.id);
/*$('.stocks_list').append('<li><a href="'+url+'">' + stock.symbol + ' </a></li>');*/
var stsres=value.active_flag;
if(stsres==1){

var sts="Active";
}
else
{

var sts="In Active";
}

             $('#statusresult').show();
            
  
$('#statusresult').append("<tr><td>" +i+ "</td><td>"+ value.comp_name + "</td><td>" + sts + "</td><td>" 
  + value.profile_type + "</td><td>" + value.end_date + '</td><td> <a class="btn btn-sm btn-primary" href='+url+'>view</a>&nbsp;<a class="btn btn-sm btn-primary ajaxbtn" data-datac='+value.id+' >Comment</a></td></tr>');

i++;
});
           }
           });
        });



  $('#mySelect').change(function(){ 

   $('#statusresultnon').hide();

    var status = $(this).val();

    //alert(status);

   // alert("");

     var url = "{{ url('company-history') }}"
        $.ajax({
           
          url: url + '/' +status,
          type: 'get',
        
          dataType: 'json',
          cache: false,
          success:function(data){
        // alert(JSON. stringify(data));
          var i=1;
 $('#statusresult').empty();
             $.each(data, function( index, value ){
             console.log(JSON. stringify(value));

             var url = '{{ route("company.history.show", ":id") }}';
             url = url.replace(':id', value.id);
/*$('.stocks_list').append('<li><a href="'+url+'">' + stock.symbol + ' </a></li>');*/

var stsres=value.active_flag;



if(stsres==1){

var sts="Active";
}
else
{

var sts="In Active";
}

             $('#statusresult').show();
            
  
$('#statusresult').append("<tr><td>" +i+ "</td><td>"+ value.comp_name + "</td><td>" + sts + "</td><td>" 
  + value.profile_type + "</td><td>" + value.end_date + '</td><td> <a class="btn btn-sm btn-primary" href='+url+'>view</a>&nbsp;<a class="btn btn-sm btn-primary ajaxbtn" data-datac='+value.id+' >Comment</a></td></tr>');

i++;
});
           }
           });
        });




function closeForm() {
  document.getElementById("myForm").style.display = "none";
}




/*$('#description').keypress(function(event){

    var keycode = (event.keyCode ? event.keyCode : event.which);
     alert(keycode);
    if(keycode == '13'){
        alert('You pressed a "enter" key in textbox');  
    }
});
*/
  $('.chatinfo').on('click',function(){



 var company= $('#company_id').val();

 //alert(company);

 var message=$('#description').val();

 console.log(message);
         
       // var id =  $(this).attr("data-id");
        var url = "{{ url('crmsupportit') }}"
        $.ajax({
          url: url + '/' + company ,
          type: 'get',
          data : {comment : message},
          success:function(data){

            $('.ulinfo').append(`
                        
                         <div class="msj macro" style="width:30;margin-left: 10px;
    margin-right: 14px;">
                    
                     <p style="color:#4682B4">${data.comment}</p>
                    
                     `);
             $("#ulinfo").animate({ scrollTop: $("#ulinfo")[0].scrollHeight},0);
     
           }


       });  

   
    $("#description").val("");
      $("#description").focus();

    })

  $('.close').on('click',function(){

    location.reload();

  });
</script>
@endsection 

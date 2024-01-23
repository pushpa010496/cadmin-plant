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
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'company-enquiries','role'=>'search'])  !!}
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
        <div>&nbsp;<br/></div>
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
                                
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($companies as $value)
                            <tr>
                                <td class="text-center"><h5>{{$i}}</h5></td>
                                <td><h5>{{$value->comp_name}}</h5></td>
                              
                                <td><h5>{{$value->active_flag == 1 ? 'Active':'In Active'}}</h5></td>
                                <td><h5>{{$value->profile_type}}</h5></td>
                              
                               
                                
                                <td class="text-right">
                                                                       
                                    <a class="btn btn-sm btn-primary" href="{{ route('company.history.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                       <input type="text" name="getcompany_id" id="getcompany_id" value="{{$value->id}}">                       
                                 <a class="btn btn-sm btn-primary" onclick="openForm();"> Comment</a>
                                </td>
                            </tr><?php $i++; ?>
                           

                        @endforeach
                    </tbody>
                </table>
                {!! $companies->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

        <div class="col-sm-4  frame chat-box chat-popup" id="myForm">
<button class="close" onclick="document.getElementById('myForm').style.display='none'" ><i class="fal fa-times"></i></button>
         <ul ui-scroll-viewport style="overflow-y: scroll; height: 350px;"  class="ulinfo" id="ulinfo">
            {{-- <li style="width:100%"><div class="msj macro"><div class="avatar"><img class="img-circle" style="width:100%;" src="https://www.ochre-media.com/images/logo.png"></div><div class="text text-l" id="result" > <p ></p><p><small>3:20 PM</small></p></div></div></li> --}}

 

         </ul>
      
      {{--   <div  id="testget"> --}}
             
            <div>
                
                <div class="">

                      
                       <div class="container">
                           
                            <div class="form-inline"><span style=" height: 30px;">
                               
                                <input class="mytext" placeholder="Type a message" id="description" name="description">
                                 <button class="chatinfo" id="users" name="users"> <i class="fa fa-2x fa-share text-primary"></i></button>
                                  <input type="text" name="company_id" id="company_id" value="">  
                                 </span>
                            </div>
                        </div>                  
                            <!--                 <div class="text text-r form-inline style="background:whitesmoke !important">
                        
                        <input class="mytext" placeholder="Type a message" name="description" /><span style="margin:left;">
                      <button type="submit" id="users" name="users"> <i class="fa fa-2x fa-share text-primary"></i></button>  
                  
                  
                   </span>
                    </div>  -->
                      
               

                </div>
              
              
                              
            </div>
            

        </div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">



function openForm() {
  /* var id = $(test).val();
        alert(id);*/

   var company= $('#getcompany_id').val();

    console.log(company);
   
 document.getElementById("myForm").style.display = "block";
  $("#description").focus();
  
    var url = "{{ url('getsupportit') }}"
        $.ajax({
           
          url: url + '/' + company ,
          type: 'get',
          dataType: 'json',
          data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
          success:function(data){
           // alert( JSON. stringify(data));
             $.each( data, function( index, value ){
               
        $('.ulinfo').append(`
                        
                         <div class="msj macro" style="width: 50;">
                     <div class="avatar">
                     <img class="img-circle" style="width:100%" src="https://www.ochre-media.com/images/logo.png">
                     </div>
                     <p style="color:#FF0000">${value.comment}</p>
                    
                     `);
         $("#ulinfo").animate({ scrollTop: $("#ulinfo")[0].scrollHeight},0);

                    }); 


          }


           });

   
      
       
}

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



 var company= $('#getcompany_id').val();

 alert(company);

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
                        
                         <div class="msj macro">
                     <div class="avatar">
                     <img class="img-circle" style="width:100%" src="https://www.ochre-media.com/images/logo.png">
                     </div>
                     <p style="color:#FF0000">${data.comment}</p>
                    
                     `);
             $("#ulinfo").animate({ scrollTop: $("#ulinfo")[0].scrollHeight},0);
     
           }


       });  
   
    $("#description").val("");
      $("#description").focus();

    })
</script>
@endsection 

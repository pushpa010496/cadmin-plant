@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
             <div class="page-header clearfix">
                <h3>
                     Products
                    <a class="btn btn-success pull-right" href="{{ route('products.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
                {!! Form::open(['method'=>'GET','url'=>'products','role'=>'search'])  !!}
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
            @if($products->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><h5>Title</h5></th>                           
                            <th><h5>Company Name</h5></th>     
                             <th><h5>Profile Name</h5></th>  
                             <th><h5>Category Name</h5></th> 
                            <th class="text-center"><h5>Status</h5></th> 
                            <th class="text-right"><h5>OPTIONS</h5></th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($products as $value)
                            <tr>
                                <td class="text-center"><strong><h5>{{$i}}</h5></strong></td>
                                <td><h5>{{$value->title}}</h5></td>
                                <td><h5>{{@$value->company->comp_name}}</h5></td>
                                <td><h5>{{@$value->compprofile->title}}</h5></td>
                                <td><h5>@foreach($value->categories as $data)
                                  {{ $data->name }}
                                   @endforeach
                                </h5></td>
                                 
                                <td class="text-center">
                                    <h5>
                                          @if($value->active_flag ==1) Active @elseif($value->active_flag == 0) Inactive @endif
                                    </h5>
                                </td>
                                <td class="text-right">
                                   <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal1{{$value->id}}"> Tags</button>
                                   <input type="hidden" name="category_id" id="categ_id" value="{{$value->category_id}}" data-ctg={{$i}}>
                                   <input type="hidden" name="product_id" id="prod_id" value="{{$value->id}}" data-product{{$i}}={{$value->id}}>
                                    
                                    <button class="btn btn-sm btn-info subtag" id="subtag" data-toggle="modal" data-target="#myModal2{{$value->id}}" data-btn={{$value->id}}> SubTags</button>

                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal{{$value->id}}"> Update Metatags ?</button>
                                    
                                    <a class="btn btn-sm btn-success" href="{{ url('products/reactivate', $value->id) }}">
                                         Active ?
                                    </a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('products.show', $value->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-warning" href="{{ route('products.edit', $value->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $value->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>

                               <div id="myModal1{{$value->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update Tags</h4>
                                      </div>
                                      <div class="modal-body">
                                        
                                             @includeIf('./tags/tagmodal')
                                       
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div id="myModal2{{$value->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update SubTags</h4>
                                      </div>
                                      <div class="modal-body">
                                        
                                             @includeIf('./subtags/subtagmodal')
                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <!-- Modal -->
                                <div id="myModal{{$value->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update Metatags</h4>
                                      </div>
                                      <div class="modal-body">
                                          {!! Form::open(array('url'=>'products/metatag/'.$value->id)) !!}
                                             @includeIf('./seoform')
                                          {!! Form::close() !!}
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                        @endforeach
                    </tbody>
                </table>
                {!! $products->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">

 /*$('#tag_id').on('change',function(){*/

 	var btnid='';

 	$(document).on('click', '.subtag', function(){
   
     btnid = $(this).data('btn');  
                     $('.checkerror').html('');


    //alert(btnid);
      });

  $(document).on('change', '#tag_id', function(){

   
    //alert($(this).closest('.modal-body').find('#ajax_id').val());
/* var category = $(this).data('category');    
 var product = $(this).data('product');  
 var tag = $(this).data('tag');*/  
  
 //var tag= $('#tag_id').val();

 var tag=$(this).find(':selected').attr('data-datac');

 //alert(tag);

 //var product_id=$(this).find('#product_id').attr('data-datap');
 //var product_id=$(this).data('data-datap');
 //var category=$(this).attr('data-datacp');
 
var product_id= $(this).closest('.modal-body').find('#ajax_id').val();
var category= $(this).closest('.modal-body').find('#category_id').val();

if(tag=="och"){
//alert("");
 $('.checkerror').html(``);

}

 //alert(product_id);
 //alert(category);
/* var category= $('#category_id').val();*/
 //alert(tag,category,product_id);
        var url = "{{ url('ajax-category') }}"
        $.ajax({
          url: url + '/' + product_id ,
          type: 'get',
          data : {tag_id : tag,category_id:category},
          success:function(data){
            var data;
            console.log(data);
              if(data !=0){
                $('.checkerror').html(`The subtag has already created under selected tag`);
              }else{
                $('.checkerror').hide();
                
              }

                          
           
     
           }


       });  

   

    });
    </script>
@endsection 
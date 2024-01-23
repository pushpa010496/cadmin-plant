

@extends('democompany/layout/company')

@section('style')

<style type="text/css">

 

</style>

@endsection

@section('content')

   <!-- // Profile Body -->

      <div class="container pt-4 pb-3">
        

          {!! Form::open(['url' => 'company-enquiry']) !!}

            <input type="hidden" name="page" value="product view">

           <div class="row">

          <div class="col-lg-9 mb-3">

            <div class="p-3 div-shadow"> 

               @foreach($prods as $prod)   

               <input type="checkbox" name="productname[]" class="custom-control-input" value="{{$prod->title}}">

               <input type="hidden" name="products" value="{{$prod->title}}">

              <div class="text-center">

                <h2 class="title text-center text-blue"><strong>{!!$prod->title!!}</strong></h2>     

                <img src="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/products/'.$prod->big_image}}" alt="{{$prod->title}}" title="{{$prod->title}}" class="img-fluid"/> 

              </div>           

                

              <div class="pt-5" >

                 {!!$prod->description!!}

              </div> 

             

              <div class="pt-3 mb-3">

               <!--  <a class="btn btn-outline-primary mr-3 mb-2" href="{{url('catalogue/'.\Request::segment(2))}}" role="button"><i class="fa fa-lg fa-file-pdf-o" aria-hidden="true"></i> &nbsp; Catalogues</a> -->

                @if(@$prod->tech_spec_pdf == '')



                <a class="btn btn-outline-primary mr-5 mb-2 disabled"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> &nbsp; Technical Specs</a>



                @else

                <a class="btn btn-outline-primary mr-5 mb-2" href="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/products/'.$prod->tech_spec_pdf}}" role="button" target="_blank"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> &nbsp; Technical Specs</a>

                @endif



                @if(@$prod->facebook)                

                  <a href="{{$prod->facebook}}" target="_blank"><img src="{{config('app.url')}}img/fb.jpg" alt="" class="img-fluid mb-2"/></a>

                @endif



                @if(@$prod->twitter)          

                <a href="{{$prod->twitter}}" target="_blank"><img src="{{config('app.url')}}img/twitter.jpg" alt="" class="img-fluid mb-2"/></a>

                 @endif



                @if(@$prod->googleplus)                

                <a href="{{$prod->googleplus}}" target="_blank"><img src="{{config('app.url')}}img/g-plus.jpg" alt="" class="img-fluid mb-2"/></a>

                @endif



                @if(@$prod->linkedin)                

                <a href="{{$prod->linkedin}}" target="_blank"><img src="{{config('app.url')}}img/linkedin.jpg" alt="" class="img-fluid mb-2"/></a>

                @endif

                </div>

                

              @endforeach



            </div>



            <div class="pt-3"></div>



            <!-- // Other Products -->

            <div class="partners">

              <div class="main-title"><span><a href="#">Other Products</a></span></div>               

            </div>

            <div class="row" id="product">              

            

              @foreach($companyprofile->pproduct->whereNotIn('url',\Request::segment(3))->where('active_flag',0)->where('stage',0) as $companyprofileroduct) 

              <div class="col-lg-4 mb-4">

                <div class="product div-shadow">

                  <div class="check">                       

                    <!-- <label class="custom-control custom-checkbox">

                      <input type="checkbox" name="productname[]" class="custom-control-input" value="{{$companyprofileroduct->title}}">

                      <span class="custom-control-indicator"></span>

                    </label> --> 

                    <div class="custom-control custom-checkbox">

                      <input type="checkbox" name="productname[]" class="custom-control-input" id="check{{$companyprofileroduct->id}}" value="{{$companyprofileroduct->title}}">

                      <label class="custom-control-label" for="check{{$companyprofileroduct->id}}"></label>

                    </div>                     

                  </div> 

                  <div id="prodimage{{$companyprofileroduct->id}}">

                    <a href="{{url('demoproducts/'.$companyprofile->url.'/'.$companyprofileroduct->url)}}"><img class="img-fluid" src="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/products/'.$companyprofileroduct->small_image}}" alt="{{$companyprofileroduct->alt_tag}}"/></a>                                           

                    <h2><a href="{{url('demoproducts/'.$companyprofile->url.'/'.$companyprofileroduct->url)}}">{!!$companyprofileroduct->title!!}</a></h2>

                  </div>

                </div>

              </div>

              @endforeach

                        

            </div>

            <!-- Other Products // -->  



          </div>



          <div class="col-lg-3 pb-3">

          

          </div>

          </div>

          {!! Form::close() !!}

       

      </div>

      

     







    </div>

@endsection

@section('scripts')

<script type="text/javascript">

  

  var product = '{{ @$prods[0]->url }}';

  var company = '{{ @$prods[0]->compprofile->url }}';

  

</script>

@if(session('message_type') == 'success')    

<script type="text/javascript">         

  

  history.pushState(null, null, '/products/'+company+'/'+product+'/enquiry-success');

  $('#myModal1').modal('show');         

</script>

@endif

<script>
    $('table').addClass('table-bordered table ').css('width','100%');

  </script>

@endsection
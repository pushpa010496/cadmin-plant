@extends('democompany/layout/company')

@section('style')

 

@endsection

@section('content')

 <!-- // Profile Body -->

  {!! Form::open(['url' => 'company-enquiry']) !!}

  <input type="hidden" name="page" value="all_pages">

      <div class="container pt-4 pb-3">

        <div class="row">

          <div class="col-lg-9 mb-3">

            <div class="row">  
             
              @foreach($companyprofile->pwp as $key => $whitepaper)                 
                  <div class="col-lg-4 mb-4">

                    <a href="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/whitepaper/'.$whitepaper->pdf}}" target="_blank">

                       <img src="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/whitepaper/'.$whitepaper->image}}" alt="{{$whitepaper->title}}" class="img-fluid div-scal"/>

                    </a>

                  </div>                

              @endforeach  

             </div> 

          </div>



          <div class="col-lg-3 pb-3">

           

          </div>

        </div>

      </div>  
    </div>

@endsection

@section('scripts')

  @if(session('message_type') == 'success')    

          <script type="text/javascript">         

         var slug = '{{ $companyprofile->url }}';

          history.pushState(null, null, '/whitepaper/'+slug+'/enquiry-success');

              $('#myModal1').modal('show');         

         </script>

      @endif

@endsection
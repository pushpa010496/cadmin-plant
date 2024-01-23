@extends('democompany/layout/company')

@section('style')



@endsection

@section('content')

 <!-- // Profile Body -->

      {!! Form::open(['url' => 'company-enquiry']) !!}

      <div class="container pt-4 pb-3">

        <div class="row">

          <div class="col-lg-9 mb-3">

            <div class="row">  

             @foreach($companyprofile->pvideo as $key => $video)                 
             <div class="col-lg-4 mb-4 video">
              <video controls="" title="{{ $video->title }}" width="100%" allowfullscreen >
                <source src="{{config('app.url').'suppliers/'.str_slug($companyprofile->company->comp_name).'/video/'.$video->video}}" type="video/mp4">
                </source>
              </video>
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

<script type="text/javascript">

var figure = $(".video").hover( hoverVideo, hideVideo );



function hoverVideo(e) {  

    $('video', this).get(0).play(); 

}



function hideVideo(e) {

    $('video', this).get(0).pause(); 

}

</script>


@endsection
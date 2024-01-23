@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3>tender / Show #{{$tender->id}}</h3>
    </div>
@endsection

@section('content')
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm btn-default" href="{{ route('tenders.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-md-6">
                 <a class="btn btn-sm btn-warning pull-right" href="{{ route('tenders.edit', $tender->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
            </div>
        </div>
    </div>
      <div class="well well-sm">
        <div class="row">
           
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->title }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i> tender notice type </h5>
              </div>
              <div class="col-md-9">
                <h5>
                  {{$tender-> tender_notice_type }}
                </h5>
              </div>
              <div class="col-md-3">              
                <h5 class="text-primary"><i class="role icon"></i> closing date </h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($tender-> closing_date )) }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Location</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->location }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Commencement</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->commencement }}</h5>
              </div>
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>tender Url</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->tender_url }}</h5>
              </div>
              
              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Home Title</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->home_title }}</h5>
              </div>

               <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Home Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->home_description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Description</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ $tender->description }}</h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Status</h5>
              </div>
              <div class="col-md-9">
                <h5>@if($tender->active_flag == 1)
                    Active
                    @elseif($tender->active_flag == 0)
                    Inactive
                    @endif
                </h5>
              </div>

              <div class="col-md-3"> 
                <h5 class="text-primary"><i class="tender icon"></i>Created Date</h5>
              </div>
              <div class="col-md-9">
                <h5>{{ date('j F Y', strtotime($tender->created_at)) }}<i class="time icon"></i> {{ date('g:i a', strtotime($tender->created_at)) }}</h5>
              </div>
       </div>
    </div>
       
     
  
@endsection

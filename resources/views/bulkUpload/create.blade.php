@extends('../layouts/app')
@section('header')
    <div class="page-header">
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i> Banners / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
               @foreach($livelinks as $link)
                <p><strong>Live : </strong> {{$link['live']}}</p>
                <p><strong>Test : </strong> {{$link['test']}}</p>
               @endforeach 
        </div>
    </div>
@endsection

@section('scripts')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  

@endsection
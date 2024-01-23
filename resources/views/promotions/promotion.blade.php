@extends('layouts.app')
<style type="text/css">
    .panel-body h4 {color: #df691a;}
    .panel-body li a {color: #fff;}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Promotions</div>

                <div class="panel-body">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status') }}
                        </div>
                    @endif

                    <h4><a href="{{url('product-enquires')}}">Product Enquires</a></h4>

                    <h4>Forms Data</h4>
                    @foreach($forms as $val)
                    <ul>
                        @if($val->type)
                        <li><a href="{{  url('leads/forms/'.$val->type) }}">{{$val->type}}</a></li>

                        @endif
                    </ul>
                    @endforeach

                      <h4>Getlisted Data</h4>
                      @foreach($getlisted as $val)
                    <ul>
                        @if($val->form_type)
                        <li><a href="{{  url('leads/get-listed-new/'.$val->form_type) }}">{{$val->form_type}}</a></li>

                        @endif
                    </ul>
                    @endforeach

                    <h4>Promotion in our website!</h4>
                    @foreach($promotiondata as $promotionpages)
                    <ul>
                        @if($promotionpages->type)
                        <li><a href="{{  url('leads/'.$promotionpages->type) }}">{{$promotionpages->type}}</a></li>

                        @endif
                    </ul>
                    @endforeach

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Enquiry for # {{$history->comp_name}}</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
      <div class="row">
        <div class="col-md-6">
          <p>company name :</p>
          <input type="text" readonly value="{{$history->comp_name}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Email : </p>
            <input type="text" readonly value="{{$history->email}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Phone :</p>
            <input type="text" readonly value="{{$history->phone}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Profile Type :</p>
            <input type="text" readonly value="{{$history->profile_type}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Start Date :</p>
            <input type="text" readonly value="{{$history->start_date}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>End Date: </p>
            <input type="text" readonly value="{{$history->end_date}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Country :</p>
            <input type="text" readonly value="{{$history->country}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>website : </p>
            <input type="text" readonly value="{{$history->website}}" class="form-control"></input>            
        </div>
        <div class="col-md-6">
            <p>Services : </p>
            <input type="text" readonly value="{{$history->services}}" class="form-control"></input>            
        </div>
        <div class="col-md-6">
            <p>Package : </p>
            <input type="text" readonly value="{{$history->package}}" class="form-control"></input>            
        </div>
         <div class="col-md-6">
            <p>Fax : </p>
            <input type="text" readonly value="{{$history->fax}}" class="form-control"></input>            
        </div>
        <div class="col-md-12">
            <p>Address : </p>
            <textarea rows='3' readonly class="form-control">{{$history->address}}</textarea>            
        </div>
       
      </div>
        

    @endif
</div>


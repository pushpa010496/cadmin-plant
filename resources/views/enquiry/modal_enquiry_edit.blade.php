<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Enquiry for # {{ $enquiry->companies->comp_name}}</h4>
</div>
<div class="modal-body">
    {!! Form::open(array('route' => 'enquiry-update')) !!}
      <input type="hidden" name="id" value="{{$enquiry->id}}">
    @if($error)
        <div>{!! $error !!}</div>
    @else
    
      <div class="row">
        <div class="col-md-6">
          <p>name :</p>
          <input type="text" name="name" value="{{$enquiry->name}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Company name : </p>
            <input type="text" name="comp_name"  value="{{$enquiry->company}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Contry : {{$enquiry->country}}</p>
            <input type="text" name="country" value="{{$enquiry->country}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Email :</p>
            <input type="text" name="email"  value="{{$enquiry->email}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Phone :</p>
            <input type="text" name="telephone" value="{{$enquiry->telephone}}" class="form-control">
        </div>
       
        <div class="col-md-12">
            <p>Message : </p>
            <textarea rows='3' name="message" class="form-control">{{$enquiry->message}}</textarea>            
        </div>

      </div>
        
        <div class="modal-footer">


      <button type="submit" class="btn btn-info pull-left">Update</button>

 
 
</div>

    @endif
     {!! Form::close() !!}
</div>



<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Enquiry for # {{ $enquiry->companies->comp_name}}</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
      <div class="row">
        <div class="col-md-6">
          <p>name :</p>
          <input type="text" readonly value="{{$enquiry->name}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Company name : </p>
            <input type="text" readonly value="{{$enquiry->company}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Country : {{$enquiry->country}}</p>
            <input type="text" readonly value="{{$enquiry->country}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Email :</p>
            <input type="text" readonly value="{{$enquiry->email}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Phone :</p>
            <input type="text" readonly value="{{$enquiry->telephone}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Page : </p>
            <input type="text" readonly value="{{$enquiry->page}}" class="form-control">
        </div>
        <div class="col-md-12">
            <p>Message : </p>
            <textarea rows='3' readonly class="form-control">{{$enquiry->message}}</textarea>            
        </div>

      </div>
        

    @endif
</div>
<div class="modal-footer">
  @if($enquiry->sent_to_client == 0)
   {!! Form::open(array('route' => 'enquiry-send')) !!}
      <input type="hidden" name="enquiries[]" value="{{$enquiry->id}}">
      <button type="submit" class="btn btn-info pull-left">Send to Client</button>
  </form>
  @endif
  <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
 
</div>

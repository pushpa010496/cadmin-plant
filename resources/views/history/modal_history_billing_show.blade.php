<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Enquiry for # </h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
      <div class="row">
        <div class="col-md-6">
          <p>Billing Company Name :</p>
          <input type="text" readonly value="{{$billing->billing_comp_name}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Contact Person : </p>
            <input type="text" readonly value="{{$billing->billing_contact_person}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Contact Number : </p>
            <input type="text" readonly value="{{$billing->billing_contact_number}}" class="form-control">
        </div>
       
        <div class="col-md-6">
            <p>Country :</p>
            <input type="text" readonly value="{{$billing->billing_country}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Email: </p>
            <input type="text" readonly value="{{$billing->billing_email}}" class="form-control">
        </div>
        <div class="col-md-6">
            <p>Billing value : </p>
            <input type="text" readonly value="{{$billing->billing_value}}" class="form-control"></input>            
        </div>
        <div class="col-md-6">
            <p>Vat/Tax/Gst : </p>
            <input type="text" readonly value="{{$billing->vat_tax_gst}}" class="form-control"></input>            
        </div>
         <div class="col-md-6">
            <p>Po No : </p>
            <input type="text" readonly value="{{$billing->po_no}}" class="form-control"></input>            
        </div>
         <div class="col-md-6">
            <p>Po Date: </p>
            <input type="text" readonly value="{{$billing->po_date}}" class="form-control"></input>            
        </div>
         <div class="col-md-6">
            <p>Tax : </p>
            <input type="text" readonly value="{{$billing->tax}}" class="form-control"></input>            
        </div>
        <div class="col-md-12">
            <p>Tax : </p>
            <textarea rows='3' readonly class="form-control">{!! $billing->billing_address !!}</textarea>            
        </div>
       
      </div>
        

    @endif
</div>


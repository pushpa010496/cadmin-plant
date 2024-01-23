 <div id="form-sticky">
              <div class="bg-light p-2 border border-secondary"> 
                <h3 class="text-center title mb-3">Product Enquiry</h3>
                  <!-- @if(session('message'))
                      <div class="alert alert-{{ session('message_type') }} alert-dismissible" id="success-alert" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          {{@session('message')}}
                      </div>
                  @endif -->
                     {!! Form::open(['url' => 'company-enquiry']) !!}
                  <div class="form-group">
                    {{Form::text('name', null,['required'=>'required','class'=>'form-control','placeholder'=>'Name*'])}}
                   
                    <input type="hidden" name="product" value="{{@$prod->title}}">
                    <input type="hidden" name="company_name" value="{{@$cp->title}}">
                    <input type="hidden" name="slug" value="{{'products/'.\Request::segment(2).'/'.\Request::segment(3)}}">
                    <input type="hidden" name="page" value="all_pages">
                    <input type="hidden" name="url_seg" value="{{ucwords(\Request::segment(1))}}">

                    @if ($errors->has('name'))
                      <div class="error text-danger">{{ $errors->first('name') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                   {{Form::text('company', null,['required'=>'required','class'=>'form-control','placeholder'=>'Company Name*'])}}
                   @if ($errors->has('company'))
                      <div class="error text-danger">{{ $errors->first('company') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    {!! Form::select('country', $countries, old('country'),['class'=>'form-control']) !!}
                
                    @if ($errors->has('country'))
                      <div class="error text-danger">{{ $errors->first('country') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                   {{Form::text('email', null,['required'=>'required','class'=>'form-control','placeholder'=>'Email*'])}}
                  @if ($errors->has('email'))
                      <div class="error text-danger">{{ $errors->first('email') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    {{Form::text('telephone', null,['required'=>'required','class'=>'form-control','placeholder'=>'Telephone*'])}}
                  @if ($errors->has('telephone'))
                      <div class="error text-danger">{{ $errors->first('telephone') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    {{Form::textarea('message', null,['rows'=>3,'class'=>'form-control','placeholder'=>'Write Message...'])}}
                    @if ($errors->has('message'))
                      <div class="error text-danger">{{ $errors->first('message') }}</div>
                    @endif
                  </div>
                 <div class="form-group">
                   {!! Form::captcha() !!}

                    @if ($errors->has('g-recaptcha-response'))
                      <div class="error text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
                    @endif
                </div>
                <button type="submit"  class="btn btn-primary btn-block">Submit</button>
                </form>
              </div>  
              <img src="{{ config('app.url') }}/img/ssl-logo.png" alt="SSL Secure Connection" width="100" class="img-fluid pull-right mt-1 mb-1" />
              <div class="clearfix"></div>
  </div>

    <div id="myModal1" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-success">{!!session('message_type')!!}</h4>
              <button type="button" class="close" onClick="location.href=location.href">&times;</button>
              
            </div>
            <div class="modal-body">
                <p class="">{!!session('message')!!}</p>
                <p>Sincerely Packaging and Labelling</p>
            <p class="mb-0">Regards,</p>
            <p class="mb-0">Client Success Team (CRM),</p>
            <img src="{{ config('app.url')}}img/main-logo.png" width="150px">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" onClick="location.href=location.href">Close</button>
              {{-- <a href="{{Request::url()}}" class="btn btn-info text-right">Close</a> --}}
            </div>
          </div>
        </div>
      </div>
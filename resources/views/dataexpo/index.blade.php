
@extends('../layouts/app')

@section('header')
    <div class="page-header clearfix">
        <h3>
            <i class="fa fa-th-list" aria-hidden="true"></i>Select Table 
           
        </h3>
    </div>

      
              

@endsection

@section('content')

   <div class="row">
  <div class="col-md-offset-3 col-md-6">
              

                <?php
//Tables_in_plantaut_laravel
                //print_r($tables);
              
                ?>
                <div class="form-group">
              {!! Form::open(array('route' => 'exportdata','method'=>'POST','files'=>'true')) !!}
                
                <div class="form-group ">
                  
                    <select name="tableinfo" id="tableinfo" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                     
                         @foreach ($tables as $key => $value)

                        <option value="<?php echo $value->Tables_in_plantaut_laravel; ?>"><?php echo $value->Tables_in_plantaut_laravel; ?></option>
                        @endforeach
                        
                    </select>
                </div>

                 



<div class="form-group ">
                     {{ Form::input('text', 'from_date', null, ['class' => 'form-control datepicker','required'=>'required','id'=>'from_date','placeholder'=>'From Date','autocomplete'=>'off']) }}
                 </div>
<div class="form-group ">
                      {{ Form::input('text', 'to_date', null, ['class' => 'form-control datepicker','required'=>'required','id'=>'to_date','placeholder'=>'To Date','autocomplete'=>'off']) }}
                </div>




                 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Export to excel</button>
                   <!--  <a class="btn btn-sm btn-default pull-right" href="{{ route('cmspages.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> -->
                </div>
            </form>

        </div>
    </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>


   $('.datepicker').datepicker({dateFormat: "yy-mm-dd",
      onSelect: function (dateText, inst) {

        var from =$("#from_date").val();
        $('#statusresultnon').hide();
        var to =$("#to_date").val();
        var url = "{{ url('profileexpire') }}"

       

      if(from==''){
alert("please select From Date");
//$("#from_date").focus();

       }

       if(to==''){
alert("please select To date");
//$("#to_date").focus();


       }
        


      }
   });

  </script>


@endsection


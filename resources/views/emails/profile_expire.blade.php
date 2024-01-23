<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html><head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Ochre Media</title>

</head>

<body>
  <table style="width: 100%; border-collapse: collapse; margin-top: 30px" align="left" border="1">
    
    <thead>
      <tr>
        <th colspan="3"  style="padding: 10px;background-color: #efa317;color:white">Profile Expiring soon</th>
      </tr>
    </thead>

    <tbody>    
      <tr>
        <th style="padding: 5px">Profile Name</th>
        <th style="padding: 5px">Start Date</th>
        <th style="padding: 5px">End Date</th>
      </tr>
      @if(count($data1))
        @foreach($data1 as $val)
        <tr>
          <td  style="padding: 5px">{{$val->comp_name }}</td>
          <td  style="padding: 5px">{{ date('d-m-Y', strtotime($val->start_date)) }}</td>
          <td  style="padding: 5px;color:#ff7800">{{  date('d-m-Y', strtotime($val->end_date))  }}</td>
        </tr>        
        @endforeach     
      @else
         <tr align="center">
          <th  colspan="3" style="padding: 5px">No Data</th>
        </tr>
        @endif      
    </tbody>
  </table>



    <table style="width: 100%; border-collapse: collapse; margin-top: 30px" align="left" border="1">
  
    <thead>
      <tr>
        <th colspan="3"  style="padding: 10px;background-color: #f55151;color:white">Profile Expires Today</th>
      </tr>
    </thead>
    <tbody>    
      <tr>
        <th style="padding: 5px">Profile Name</th>
        <th style="padding: 5px">Start Date</th>
        <th style="padding: 5px">End Date</th>
      </tr>
       @if(count($data2))
      @foreach($data2 as $val)
        <tr>
          <td  style="padding: 5px">{{$val->comp_name }}</td>
          <td  style="padding: 5px">{{ date('d-m-Y', strtotime($val->start_date)) }}</td>
          <td  style="padding: 5px;color:red">{{ date('d-m-Y', strtotime($val->end_date)) }}</td>
        </tr>        
      @endforeach   
      @else
         <tr align="center">
          <th style="padding: 5px" colspan="3">No Data</th>
        </tr>
      @endif  
    </tbody>
  </table>

</body></html>
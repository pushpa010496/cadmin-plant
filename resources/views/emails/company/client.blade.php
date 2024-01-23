<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html><head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Ochre Media</title>

</head>

<body>
  <table>
    <tbody>
      <tr>
        <th>Company ID</th>
        <th>Company Name</th>
        <th>Email</th>
      </tr>
      @foreach($data as $val)
        <tr>
          <td>{{$val->id }}</td>
          <td>{{$val->comp_name }}</td>
          <td>{{$val->email }}</td>
        </tr>
        
      @endforeach     
    </tbody>
  </table>

</body></html>
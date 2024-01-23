<option>--- Select One ---</option>
@if(!empty($profiles))
  @foreach($profiles as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif
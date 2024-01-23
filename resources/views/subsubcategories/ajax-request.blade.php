                    <option value="0">Sub Category</option>
                    @foreach ($categories as $category)                                         
                     <option value="{{$category->id}}">{{$category->subcat_name}}</option>
                    @endforeach	
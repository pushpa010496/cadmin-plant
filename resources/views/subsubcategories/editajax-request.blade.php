                    <option value="">Select Category</option>
                    <option value="0" @if($selcatid == 0) selected @endif >Main Category</option>
                    @foreach ($categories as $category)
                     @if($category->subcat_id == 0)
                    <optgroup label="{{$category->cat_name}}">-{{ $category->cat_name }}</optgroup>                      
                     <option value="{{$category->id}}" @if($category->id == $selcatid) selected @endif >{{$category->cat_name}}</option>
                        @foreach ($category->children as $children)
                            <option value="{{$children->id}}" @if($children->id == $selcatid) selected @endif > --{{$children->cat_name}}</option>
                                 @foreach ($children->children as $firtstchildren)
                                    <option value="{{$firtstchildren->id}}" @if($firtstchildren->id == $selcatid) selected @endif> ---{{$firtstchildren->cat_name}}</option>
                                        @foreach ($firtstchildren->children as $secondchildren)
                                            <option value="{{$secondchildren->id}}" @if($secondchildren->id == $selcatid) selected @endif> ----{{$secondchildren->cat_name}}</option>
                                               @foreach ($secondchildren->children as $thirdchildren)
                                                <option value="{{$thirdchildren->id}}" @if($thirdchildren->id == $selcatid) selected @endif > -----{{$thirdchildren->cat_name}}</option>
                                            @endforeach
                                        @endforeach
                                @endforeach
                        @endforeach
                    @endif
                @endforeach	
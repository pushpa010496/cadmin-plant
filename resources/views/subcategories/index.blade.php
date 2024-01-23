@extends('../layouts/app')
@section('content')
<div class="content">
        <div class="col-md-offset-3 col-md-6">
             <div class="page-header clearfix">
                <h3>
                     Sub Category
                    <a class="btn btn-success pull-right" href="{{ route('subcategories.create') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create</a>
                </h3>               
            </div>
             <div class="col-md-12">
          {!! Form::open(['method'=>'GET','url'=>'subcategories','role'=>'search'])  !!}
              <div id="custom-search-input">
                <div class="input-group col-md-12 pull-right">
                    <input type="text" class="search-query form-control" placeholder="Search" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>

                        </button>
                    </span>
                </div>
              </div>
         {!! Form::close() !!}
        </div>
        </div>

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            @if($subcategories->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Sub Category Name</th>                           
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody><?php $i=1; ?>
                        @foreach($subcategories as $category)
                            <tr>
                                <td class="text-center"><strong>{{$i}}</strong></td>

                                <td>{{$category->subcat_name}}</td>
                                
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('subcategories.show', $category->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </a>
                                    
                                    <a class="btn btn-sm btn-warning" href="{{ route('subcategories.edit', $category->id) }}">
                                       <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </a>

                                    <form action="{{ route('subcategories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-2" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr><?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                {!! $subcategories->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    </div>

@endsection 
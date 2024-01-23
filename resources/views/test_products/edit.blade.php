@extends('../layouts/app')
@section('style')
<style type="text/css">
  *,
*:before,
*:after {
    -webkit-box-sizing: border-box; 
    -moz-box-sizing: border-box; 
    box-sizing: border-box;
}

#integration-list {
    font-family: 'Open Sans', sans-serif;
    width: 100%;
    margin: 0 auto;
    display: table;
}
#integration-list ul {
    padding: 0;
    margin: 20px 0;
    color: #555;
    background-color: #fff;
}
#integration-list ul > li {
    list-style: none;
    border-top: 1px solid #ddd;
    display: block;
    padding: 15px;
    overflow: hidden;
    background: #ccc;
}
#integration-list ul:last-child {
    border-bottom: 1px solid #ddd;
}
#integration-list ul > li:hover {
    background: #ccc;
}
.expand {
    display: block;
    text-decoration: none;
    color: #555;
    cursor: pointer;
}
h2 {
    padding: 0;
    margin: 0;
    font-size: 17px;
    font-weight: 400;
}
span {
    font-size: 12.5px;
}
#left,#right{
    display: table;
}
#sup{
    display: table-cell;
    vertical-align: middle;
    width: 80%;
}
.detail a {
    text-decoration: none;
    color: #C0392B;
    border: 1px solid #C0392B;
    padding: 6px 10px 5px;
    font-size: 14px;
}
.detail { 
  display: none;
  /*  margin: 10px 0 10px 0px;
   
    line-height: 22px;
    height: 150px;*/
}
.detail span{
    margin: 0;
}
/*.right-arrow {
    margin-top: 12px;
    margin-left: 20px;
    width: 10px;
    height: 100%;
    float: right;
    font-weight: bold;
    font-size: 20px;
}*/
.icon {
    height: 75px;
    width: 75px;
    float: left;
    margin: 0 15px 0 0;
}
.london {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
.newyork {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
.paris {
    background: url("http://placehold.it/50x50") top left no-repeat;
    background-size: cover;
}
</style>
@endsection
@section('header')
    <div class="page-header">
        <h3> Products / Edit #{{$product->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

   <div class="row">
        <div class="col-md-offset-3 col-md-8 col-md-offset-3">

            <form action="{{ route('testproducts.update', $product->id) }}" method="POST" enctype= "multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

             {!! Form::open(array('route' => 'testproducts.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, old('company_id',$product->company_id), ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_profile_id', 'Select Profile:') !!}
                    {!! Form::select('company_profile_id',$profilelist,old('company_profile_id',$product->company_profile_id),['class'=>'form-control','placeholder'=>'Select Profile']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('category_id', 'Category:') !!}
                   {!! \App\Category::attr(['name' => 'category_id','class'=>'form-control','placeholder'=>'Selcet One'])
                   ->selected($product->category_id)
                   ->renderAsDropdown() !!}
                </div>
                <div class="form-group">
                    {!! Form::label('title', ' Title:') !!}
                    {{ Form::input('text', 'title', old('title',$product->title), ['class' => 'form-control','required'=>'required']) }}
                </div>

                 <div class="form-group">
                    {!! Form::label('small_image', 'Small Image:') !!}
                     {!! Form::file('small_image', array('class' => '')) !!}
                      @if($product->small_image)
                       <img width="100" src="<?php echo config('app.url'); ?>temp_companies/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->small_image;?>">
                     @endif
                </div>
                  <div class="form-group">
                    {!! Form::label('big_image', 'Big Image:') !!}
                    {!! Form::file('big_image', array('class' => '')) !!}
                      @if($product->big_image)
                       <img width="100" src="<?php echo config('app.url'); ?>temp_companies/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->big_image;?>">
                     @endif
                </div>
                 
                <div class="form-group">
                    {!! Form::label('title_tag', 'Img Title:') !!}
                    {{ Form::input('text', 'title_tag',  old('title_tag',$product->title_tag), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('alt_tag', 'Img Alt:') !!}
                    {{ Form::input('text', 'alt_tag',  old('alt_tag',$product->alt_tag), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('tech_spec_pdf', 'tech spec pdf:') !!}
                     {!! Form::file('tech_spec_pdf', array('class' => '')) !!}
                      @if($product->tech_spec_pdf)
                      <a href="<?php echo config('app.url'); ?>temp_companies/<?php echo str_slug($product->company->comp_name);?>/products/<?php echo $product->tech_spec_pdf;?>">View Pdf</a>
                     @endif
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', old('description',$product->description),
                     ['class' => 'form-control my-editor']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('url', 'url:') !!}
                    {{ Form::input('text', 'url', old('url',$product->url), ['class' => 'form-control','required'=>'required']) }}
                </div> 
                  <div class="form-group">
                       {!! Form::label('display_order', 'Display Order:') !!}
                        {{ Form::input('number', 'display_order',  old('display_order',$product->display_order), ['class' => 'form-control']) }}
                              
                  </div>              
                <div id="integration-list">
                  <ul>
                      <li>
                          <a class="expand">
                            <span class="pull-right fa-lg">+</span>                              
                              <div>
                                Social Links
                              </div>
                          </a>

                          <div class="detail">
                             <div class="form-group">
                                  {!! Form::label('googleplus', 'Google Plus:') !!}
                                  {{ Form::input('text', 'googleplus', old('googleplus',$product->googleplus), ['class' => 'form-control']) }}
                              </div>              
                              <div class="form-group">
                                  {!! Form::label('linkedin', 'Linkedin:') !!}
                                  {{ Form::input('text', 'linkedin', old('linkedin',$product->linkedin), ['class' => 'form-control']) }}
                              </div>
                              <div class="form-group">
                                  {!! Form::label('twitter', 'Twitter:') !!}
                                  {{ Form::input('text', 'twitter', old('twitter',$product->twitter), ['class' => 'form-control']) }}
                              </div>              
                              <div class="form-group">
                                  {!! Form::label('facebook', 'Facebook:') !!}
                                  {{ Form::input('text', 'facebook', old('facebook',$product->facebook), ['class' => 'form-control']) }}
                              </div>
                          </div>
                      </li>                      
                  </ul>
              </div>
                <div id="integration-list">
                  <ul>
                      <li>
                          <a class="expand">
                            <span class="pull-right fa-lg">+</span>                              
                              <div>
                                Search Keywords
                              </div>
                          </a>

                          <div class="detail">
                             <div class="form-group">
                                  {!! Form::label('keyword1', 'Keyword 1:') !!}
                                  {{ Form::input('text', 'keyword1', old('keyword1',$product->keyword1), ['class' => 'form-control']) }}
                              </div>              
                             <div class="form-group">
                                  {!! Form::label('keyword2', 'Keyword 2:') !!}
                                  {{ Form::input('text', 'keyword2', old('keyword2',$product->keyword2), ['class' => 'form-control']) }}
                              </div>              
                             <div class="form-group">
                                  {!! Form::label('keyword3', 'Keyword 3:') !!}
                                  {{ Form::input('text', 'keyword3', old('keyword3',$product->keyword3), ['class' => 'form-control']) }}
                              </div>              
                             
                             <div class="form-group">
                                  {!! Form::label('keyword4', 'Keyword 4:') !!}
                                  {{ Form::input('text', 'keyword4', old('keyword4',$product->keyword4), ['class' => 'form-control']) }}
                              </div>              
                             
                             <div class="form-group">
                                  {!! Form::label('keyword5', 'Keyword 5:') !!}
                                  {{ Form::input('text', 'keyword5', old('keyword5',$product->keyword5), ['class' => 'form-control']) }}
                              </div>              
                          </div>
                      </li>                      
                  </ul>
              </div>
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}

                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        @if($product->active_flag == 1)
                        <option value="1" selected="selected">Active</option>
                        <option value="0">InActive</option>
                        @elseif($product->active_flag == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="selected">InActive</option>
                        @endif
                    </select>
                </div>
                               
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    
                     <a class="btn btn-sm btn-default pull-right" href="{{ route('testproducts.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
<script>
     var options = {
    filebrowserImageBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Images',
    filebrowserImageUploadUrl: '{{public_path("article")}}/?type=Images&_token=',
    filebrowserBrowseUrl: '<?php echo config("app.url"); ?>article/?type=Files',
    filebrowserUploadUrl: '{{public_path("article")}}/?type=Files&_token='
    };
  $('textarea.my-editor').ckeditor(options);
</script>


<script type="text/javascript">
  $("select[name='company_id']").change(function(){
      var company_id = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo url('select-ajax') ?>",
          method: 'GET',
          data: {company_id:company_id, _token:token},
          success: function(data) {
            $("select[name='company_profile_id'").html('');
            $("select[name='company_profile_id'").html(data.options);
          }
      });
  });

  $(function() {
  $(".expand").on( "click", function() {
    $(this).next().slideToggle(200);
    $expand = $(this).find(">:first-child");
    
    if($expand.text() == "+") {
      $expand.text("-");
    } else {
      $expand.text("+");
    }
  });
});
   $("select[id='catid']").change(function(){
      var catid = $(this).val();

      $.get('{{url("/")}}/ajax-cate/'+catid,function(data) {

            $("#subcatid").empty().append(data);      
       });
      });
  
</script>
@endsection
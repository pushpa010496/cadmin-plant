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
        <h3><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Products / Create </h3>
    </div>
@endsection

@section('content')
    @include('error')
     <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3">

                 {!! Form::open(array('route' => 'products.store','files'=>true)) !!}
                <div class="form-group">
                    {!! Form::label('company_id', 'Company:') !!}
                    {{ Form::select('company_id', $companylist, null, ['class' => 'form-control','required'=>'required','placeholder'=>'Select Company']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('company_profile_id', 'Select Profile:') !!}
                    {!! Form::select('company_profile_id',[''=>'--- Select One ---'],null,['class'=>'form-control','required'=>'required']) !!}
                </div>
                  <div class="form-group">
                     <?php $cat = getcat(22); ?>
                    {!! Form::label('category_id', 'Category:') !!}
                       {!! Form::select('category_id',$cat,null,['class'=>'form-control', 'required'=>'required','placeholder'=>'Select category','id'=>'catid']) !!}
                </div>
                <div class="form-group" id="subcatid">
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {{ Form::input('text', 'title', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('small_image', 'Samll Image :') !!}
                    {{ Form::file('small_image', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('big_image', 'Big Image :') !!}
                    {{ Form::file('big_image', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('alt_tag', 'Alt Tag:') !!}
                    {{ Form::input('text', 'alt_tag', null, ['class' => 'form-control','required'=>'required']) }}
                </div>              
                <div class="form-group">
                    {!! Form::label('title_tag', 'Title Tag:') !!}
                    {{ Form::input('text', 'title_tag', null, ['class' => 'form-control','required'=>'required']) }}
                </div>
                 <div class="form-group">
                    {!! Form::label('tech_spec_pdf', 'Tech spec pdf:') !!}
                     {!! Form::file('tech_spec_pdf', array('class' => '')) !!}
                </div>
                 <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {{ Form::textarea('description', null,
                     ['class' => 'form-control my-editor']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('url', 'url:') !!}
                    {{ Form::input('text', 'url', null, ['class' => 'form-control','required'=>'required']) }}
                </div>  
                 <div class="form-group">
                    {!! Form::label('display_order', 'Display Order:') !!}
                    {{ Form::input('number', 'display_order', null, ['class' => 'form-control']) }}
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
                                  {{ Form::input('text', 'googleplus', null, ['class' => 'form-control']) }}
                              </div>              
                              <div class="form-group">
                                  {!! Form::label('linkedin', 'Linkedin:') !!}
                                  {{ Form::input('text', 'linkedin', null, ['class' => 'form-control']) }}
                              </div>
                              <div class="form-group">
                                  {!! Form::label('twitter', 'Twitter:') !!}
                                  {{ Form::input('text', 'twitter', null, ['class' => 'form-control']) }}
                              </div>              
                              <div class="form-group">
                                  {!! Form::label('facebook', 'Facebook:') !!}
                                  {{ Form::input('text', 'facebook', null, ['class' => 'form-control']) }}
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
                                  {{ Form::input('text', 'keyword1', null, ['class' => 'form-control']) }}
                              </div>              
                             <div class="form-group">
                                  {!! Form::label('keyword2', 'Keyword 2:') !!}
                                  {{ Form::input('text', 'keyword2', null, ['class' => 'form-control']) }}
                              </div>              
                             <div class="form-group">
                                  {!! Form::label('keyword3', 'Keyword 3:') !!}
                                  {{ Form::input('text', 'keyword3', null, ['class' => 'form-control']) }}
                              </div>              
                             
                             <div class="form-group">
                                  {!! Form::label('keyword4', 'Keyword 4:') !!}
                                  {{ Form::input('text', 'keyword4', null, ['class' => 'form-control']) }}
                              </div>              
                             
                             <div class="form-group">
                                  {!! Form::label('keyword5', 'Keyword 5:') !!}
                                  {{ Form::input('text', 'keyword5', null, ['class' => 'form-control']) }}
                              </div>              
                          </div>
                      </li>                      
                  </ul>
              </div>
                <div class="form-group">
                    {!! Form::label('active_flag', 'Status:') !!}
                    <select name="active_flag" class="form-control" required="required">
                        <option value="">-- Select one --</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                <div class="form-group">
                  {!! Form::label('stage', 'Stage:') !!}
                  <select name="stage" class="form-control" required="required">
                    <option value="">-- Select one --</option>
                    <option value="1">Live</option>
                    <option value="0">Test</option>
                  </select>
                </div>
               <div class="well well-sm">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <a class="btn btn-sm btn-default pull-right" href="{{ route('products.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>  
          
               
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('textarea.my-editor').ckeditor();

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
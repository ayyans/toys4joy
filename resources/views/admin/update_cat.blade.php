@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            Edit categories
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{route('admin.edit_category_process')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <input type="hidden" name="catid" value="{{$cat->id}}" />
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Category Name (English)</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control categoriesfrm" placeholder="write here category name" name="catname[en]" value="{{ $cat->getTranslation('category_name', 'en') }}"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Category Name (Arabic)</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control categoriesfrm" placeholder="write here category name" name="catname[ar]" value="{{ $cat->getTranslation('category_name', 'ar') }}"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Type</label>
                            </div>
                            <div class="col-lg-9">
                                <select type="text" class="form-control categoriesfrm" name="catType">
                                    @if($cat->category_type==1)
                                    <option value="1" selected>Physical</option>
                                    <option value="2">Digital</option>
                                    @elseif($cat->category_type==2)
                                    <option value="1" >Physical</option>
                                    <option value="2" selected>Digital</option>
                                    @endif

                            </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Banner</label>
                            </div>
                            <div class="col-lg-9">
                                <img src="{{asset('uploads/'.$cat->cat_banner)}}" style="width:100px" />
                                <input type="file" class="form-control " name="catBanner"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Icon</label>
                            </div>
                            <div class="col-lg-9">
                            <img src="{{asset('uploads/'.$cat->cat_icon)}}" style="width:100px" />
                                <input type="file" class="form-control " name="catIcon"/>
                            </div>
                        </div>

                       <button type="btn" class="btn btn-success categorieSubmit">Update</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
@stop

@push('otherscript')
<script>
    $(function(){
        $("button.categorieSubmit").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.categoriesfrm').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

        $('select.categoriesfrm').each(function() {
            if ($.trim($(this).val()) == '0') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

       
       

        if (isValid == false){ 
            e.preventDefault();
        }
        else {
            $('form#categoryFRM').submit();
        }
    });

      
    })
</script>

@endpush
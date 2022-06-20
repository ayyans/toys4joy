@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            Add categories
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{route('admin.cateProcess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Category Name</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control categoriesfrm" placeholder="write here category name" name="catname"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Type</label>
                            </div>
                            <div class="col-lg-9">
                                <select type="text" class="form-control categoriesfrm" name="catType">
                                    <option value="0">--select type--</option>
                                    <option value="1">Physical</option>
                                    <option value="2">Digital</option>
                            </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Banner</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="file" class="form-control categoriesfrm" name="catBanner"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Icon</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="file" class="form-control categoriesfrm" name="catIcon"/>
                            </div>
                        </div>

                       <button type="btn" class="btn btn-success categorieSubmit">Submit</button>
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
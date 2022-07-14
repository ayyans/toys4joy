@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">
    <div class="col-md-4"></div>
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
           Bulk Edit Product
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form action="{{route('admin.bulkupdateprocess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                            <label>Select File</label>
                            <input accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" style="height: 45px;" class="form-control categoriesfrm" name="file"/>
                        </div>
                       <button type="btn" class="btn btn-success categorieSubmit">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    <div class="col-lg-8">
<!-- DataTales Example -->
</div>
</div>

</div>
<!-- /.container-fluid -->
@stop
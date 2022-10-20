@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Bulk Upload Products</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store-bulk-upload-products') }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
            <input type="file" name="file" id="file">
            <button type="submit" class="btn btn-sm btn-outline-primary">Bulk Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
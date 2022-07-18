@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Inventory Report</h1>
    <a href="{{ route('admin.report.inventory', ['export' => 'true']) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <div class="row">

    <div class="col-md-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Total Products</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productsCount }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Total Categories</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoriesCount }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Subcategories
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $subcategoriesCount }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <table class="datatable table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>SKU</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Subcategory</th>
          <th>Description</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
          <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->unit_price }}</td>
            <td>{{ $product->qty }}</td>
            <td>{{ $product->category_id }}</td>
            <td>{{ $product->sub_cat }}</td>
            <td><a href="#" class="text-decoration-none" data-description="{{ $product->long_desc }}" data-toggle="modal" data-target="#descriptionModal">view</a></td>
            <td>{{ $product->status }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="descriptionModalTitle">Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="description"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('otherscript')
<script>
$(document).ready(function () {
  $('.datatable').DataTable();
});

$('#descriptionModal').on('show.bs.modal', function (e) {
  const button = $(e.relatedTarget);
  const description = button.data('description');
  const modal = $(this);
  modal.find('#description').text(description);
})
</script>
@endpush
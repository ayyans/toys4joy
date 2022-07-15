@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sales Report</h1>
    <div class="d-flex">
      <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
        <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  </div>

  <div id="filter-container" class="mb-3 border p-3 rounded">
    <form action="{{ route('admin.report.sales') }}" method="get">
      <div class="row">
        <div class="col-6 col-md-5">
          <div class="form-group mb-0">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->start_date }}" required>
          </div>
        </div>
        <div class="col-6 col-md-5">
          <div class="form-group mb-0">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->end_date }}" required>
          </div>
        </div>
        <div class="col-12 col-md-2">
          <div class="form-group">
            <label for="end_date">ㅤ</label>
            <button type="submit" class="btn btn-dark btn-block">Apply</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="row">

    <div class="col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Products Sold</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productsSold }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Total Revenue</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $revenueCount }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
        <th>Sales</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
        <tr>
          <td>{{ $product['title'] }}</td>
          <td>{{ $product['sales'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('otherscript')
<script>
$(function () {
  // datatables
  $('.datatable').DataTable({
    'order': [[1, 'desc']]
  });

  // filters
  $('#filter-button').on('click', function() {
    $('#filter-container').slideToggle();
  })
});
</script>
@endpush
@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Coupons Report</h1>
    <div class="d-flex">
      <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
        <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  </div>

  <div id="filter-container" class="mb-3 border p-3 rounded">
    <form action="{{ route('admin.report.coupons') }}" method="get">
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

  <table class="datatable table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Type</th>
        <th>Code</th>
        <th>Discount</th>
        <th>Expiry</th>
        <th>Total Usage</th>
        <th>Usage by Users</th>
      </tr>
    </thead>
    <tbody>
      @php $count = 1 @endphp
      @foreach ($coupons as $coupon)
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $coupon['title'] }}</td>
          <td>{{ $coupon['type'] }}</td>
          <td>{{ $coupon['code'] }}</td>
          <td>{{ $coupon['discount'] }}</td>
          <td>{{ $coupon['expiry'] }}</td>
          <td>{{ $coupon['usage'] }}</td>
          <td><a href="#" class="text-decoration-none" data-users="{{ $coupon['usage_by_users'] }}" data-toggle="modal" data-target="#usageByUsersModal">view</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="usageByUsersModal" tabindex="-1" role="dialog" aria-labelledby="usageByUsersModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usageByUsersModalTitle">Usage By Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="usage-table" class="table table-bordered">
          <thead>
            <tr>
              <th>Phone</th>
              <th>Usage</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
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
$(function () {
  // datatables
  $('.datatable').DataTable();

  // filters
  $('#filter-button').on('click', function() {
    $('#filter-container').slideToggle();
  })

  // modal
  $('#usageByUsersModal').on('show.bs.modal', function (e) {
  const button = $(e.relatedTarget);
  const usage = button.data('users');
  const modal = $(this);
  $('#usage-table tbody').empty();
  Object.entries(usage).forEach(
      ([key, value]) => $('#usage-table tbody').append(
        `<tr>
          <td>${key}</td>
          <td>${value}</td>
        </tr>`
      )
  );
})
});
</script>
@endpush
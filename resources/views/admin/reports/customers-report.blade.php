@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Customers Report</h1>
    <div class="d-flex">
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  </div>

  <table class="datatable table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Total Orders</th>
        <th>Total Spent</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td>{{ $user['name'] }}</td>
          <td>{{ $user['total_orders'] }}</td>
          <td>{{ $user['total_amount'] }}</td>
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
    'order': [[2, 'desc']]
  });
});
</script>
@endpush
@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Generated Gift Cards Report</h1>
    <div class="d-flex">
      <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
        <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  </div>

  <div id="filter-container" class="mb-3 border p-3 rounded">
    <form action="{{ route('admin.report.generatedGiftCards') }}" method="get">
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
        <th>Code</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Type</th>
        <th>Date Generated</th>
      </tr>
    </thead>
    <tbody>
      @php $count = 1 @endphp
      @foreach ($userGiftCards as $userGiftCard)
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $userGiftCard['code'] }}</td>
          <td>{{ $userGiftCard['name'] }}</td>
          <td>{{ $userGiftCard['mobile'] }}</td>
          <td>{{ $userGiftCard['type'] }}</td>
          <td>{{ $userGiftCard['date_generated'] }}</td>
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
  $('.datatable').DataTable();

  // filters
  $('#filter-button').on('click', function() {
    $('#filter-container').slideToggle();
  })
});
</script>
@endpush
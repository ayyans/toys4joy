@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Customers Report</h1>
    <div class="d-flex">
      <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
        <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  </div>

  <div id="filter-container" class="mb-3 border p-3 rounded">
    <form action="{{ route('admin.report.customers') }}" method="get">
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
        <th>Name</th>
        <th>Mobile</th>
        <th>Address</th>
        <th>Siblings</th>
        <th>Points</th>
        <th>Total Orders</th>
        <th>Total Spent</th>
      </tr>
    </thead>
    <tbody>
      @php $count = 1 @endphp
      @foreach ($users as $user)
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $user['name'] }}</td>
          <td>{{ $user['mobile'] }}</td>
          <td><a href="#" class="text-decoration-none" data-title="Address" data-body="{{ $user['address'] }}" data-toggle="modal" data-target="#popupModal">view</a></td>
          <td><a href="#" class="text-decoration-none" data-title="Siblings" data-body="{{ $user['siblings'] }}" data-toggle="modal" data-target="#popupModal">view</a></td>
          {{-- <td>{{ $user['address'] }}</td> --}}
          {{-- <td>{{ $user['siblings'] }}</td> --}}
          <td>{{ $user['points'] }}</td>
          <td>{{ $user['total_orders'] }}</td>
          <td>{{ $user['total_amount'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popupModalTitle">
          <span id="title"></span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="body"></p>
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

  // popup modal
  $('#popupModal').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const title = button.data('title');
    const body = button.data('body');
    const modal = $(this);
    modal.find('#title').text(title);
    if (title == 'Siblings') {
      const genders = ['boy', 'girl'];
      const numbers = ['one', 'two', 'three', 'four', 'five'];
      let table = `<table style="width: 100%; text-align: center">`;
      table += `<tr><th>Name</th><th>Gender</th><th>Date of birth</th></tr>`;
      for (const gender of genders) {
        for (const number of numbers) {
          const name = body[`${gender}_${number}_name`];
          const dob = body[`${gender}_${number}_dob`];
          if (name) {
            table += `<tr><td>${name}</td><td>${gender.toUpperCase()}</td><td>${dob}</td></tr>`;
          }
        }
      }
      table += `</table>`;
      modal.find('#body').html(table);
    } else {
      modal.find('#body').text(body);
    }
  })
});
</script>
@endpush
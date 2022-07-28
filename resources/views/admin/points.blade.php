@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Points</h1>
    {{-- <div class="d-flex">
      <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div> --}}
  </div>

  <div class="row">

    <div class="col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Total Given Points</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBalance }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-300"></i>
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
                Eligible Users</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $eligibleUsers->count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
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
        <th>Balance</th>
        <th>Transactions</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($eligibleUsers as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->balance }}</td>
          <td><a href="#" class="text-decoration-none" data-transactions="{{ $user->transactions }}" data-toggle="modal" data-target="#transactionsModal">view</a></td>
          <td>
            <a href="#">Generate E-Gift Card</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="transactionsModal" tabindex="-1" role="dialog" aria-labelledby="transactionsModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transactionsModalTitle">Transactions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="transactionsTable" class="table table-hover table-bordered">
          <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Date</th>
          </tr>
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
  $('.datatable').DataTable({
    'order': [[1, 'desc']]
  });

  $('#transactionsModal').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const transactions = button.data('transactions');
    const modal = $(this);
    const table = modal.find('#transactionsTable');
    for (const transaction of transactions) {
      table.append(
      `
        <tr>
          <td>${transaction.type}</td>
          <td>${transaction.amount}</td>
          <td>${transaction.meta ? transaction.meta.description : 'no description'}</td>
          <td>${new Date(Date.parse(transaction.created_at)).toDateString()}</td>
        </tr>
      `
      );
    }
  })
});
</script>
@endpush
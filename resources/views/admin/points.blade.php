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
          <td><a href="#" class="text-decoration-none" data-type="transactions" data-title="Transactions" data-transactions="{{ $user->transactions }}" data-toggle="modal" data-target="#transactionsModal">view</a></td>
          <td><a href="#" class="text-decoration-none" data-type="giftcard" data-title="E-Gift Card" data-id="{{ $user->id }}" data-points="{{ $points }}" data-reward="{{ $reward }}" data-toggle="modal" data-target="#transactionsModal">Generate E-Gift Card</a></td>
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
        <div id="giftcardInformation">
          <h3 class="display-6 text-center text-dark">E-Gift Card Code is: <span class="text-primary" id="gift-code"></span></h3>
        </div>
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
    const type = button.data('type');
    const title = button.data('title');
    const modal = $(this);
    modal.find('#transactionsModalTitle').text(title);
    if (type == 'transactions') {
      modal.find('#giftcardInformation').hide(); // hide gift part section
      modal.find('#transactionsTable').show(); // show transaction table if hidden
      const transactions = button.data('transactions');
      const table = modal.find('#transactionsTable');
      table.empty(); // empty table if filled
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
    } else {
      modal.find('#transactionsTable').hide(); // hide transactions table
      modal.find('#giftcardInformation').show(); // show gift part if hidden
      const url = "{{ route('admin.addgiftcardsubmit') }}";
      const user_id = button.data('id');
      const points = button.data('points');
      const reward = button.data('reward');
      const random = Math.random().toString(16).substr(2, 6); // random 6 characters
      const code = `gift${random}`; // code will be gift+random
      // data to send
      const data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        user_id,
        coupon_title: `${points} Points Gift Card`,
        coupon_code: code,
        price: reward,
        points,
        status: 1,
        type: 'reward' // if it's reward deduce balance and send mail
      }
      // ajax request
      fetch(url,
      {
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          method: "POST",
          body: JSON.stringify(data)
      })
      .then(function(res){
        if (res.status) {
          modal.find('#gift-code').text(code);
        }
      })
      .catch(function(res){ console.log(res) })
    }
  })

  $('#transactionsModal').on('hide.bs.modal', function() {
    location.reload();
  });
});
</script>
@endpush
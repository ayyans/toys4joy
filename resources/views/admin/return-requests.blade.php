@extends('admin.layouts.master')
@push('otherstyle')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/panzoom.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
@endpush
@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">All Return Requests</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>User</th>
              <th>Reason</th>
              <th>Detail</th>
              <th>Recipt</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($returnRequests as $returnRequest)
            <tr>
              <td>{{ $returnRequest->created_at->format('Y-m-d') }}</td>
              <td>{{ $returnRequest->created_at->format('H:m:s') }}</td>
              <td>{{ $returnRequest->user->name }}</td>
              <td>{{ $returnRequest->reason }}</td>
              <td>{{ $returnRequest->detail }}</td>
              <td class="text-center">
                <img data-fancybox src="{{ asset("storage/{$returnRequest->receipt}") }}" alt="Receipt" role="button" height="25">
              </td>
              <td>
                @if($returnRequest->status == 'in-progress')
                  <div class="badge badge-primary">In Progress</div>
                @elseif($returnRequest->status == 'accepted')
                  <div class="badge badge-success">Accepted</div>
                @elseif($returnRequest->status == 'rejected')
                  <div class="badge badge-danger">Rejected</div>
                @endif
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-dark">Info</button>
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    @if ($returnRequest->status == 'in-progress')
                      <li>
                        <a href="{{ route('admin.return-requests.status', ['returnRequest' => $returnRequest->id, 'status' => 'accepted']) }}" class="dropdown-item">Accept</a>
                      </li>
                      <li>
                        <a href="{{ route('admin.return-requests.status', ['returnRequest' => $returnRequest->id, 'status' => 'rejected']) }}" class="dropdown-item">Reject</a>
                      </li>
                    @endif
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('otherscript')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
  $(function () {
  // datatables
  $('.datatable').DataTable({
    'order': [[1, 'desc']]
  });
});
</script>
@endpush
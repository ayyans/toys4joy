@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Return Order #{{ $order->order_number }}</h1>
  </div>

  <div class="row">

    <div class="col-md-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Subtotal</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $order->subtotal }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Discount</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $order->discount }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                Total Amount</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $order->total_amount }}</div>
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
        <th>#</th>
        <th>Name</th>
        <th>Original Price</th>
        <th>Purchase Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @php $count = 1 @endphp
      @foreach ($order->items as $item)
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $item->product->title }}</td>
          <td>{{ $item->price - $item->discount }}</td>
          <td>{{ reduceByPercentage($item->price - $item->discount, $discountPercentage) }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{{ reduceByPercentage($item->total_amount, $discountPercentage) }}</td>
          <td>
            @if ($item->status == 'returned')
            <p class="text-danger">Returned</p>
            @else
            <a href="{{ route('admin.returnItemProceed', ['order' => $order->id, 'item' => $item->id]) }}" onclick="return confirm('Are you sure you want to return this item?')">Return</a>
            @endif
          </td>
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
});
</script>
@endpush
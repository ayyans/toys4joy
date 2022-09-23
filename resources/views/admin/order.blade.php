@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $type ?? null == 'wishlist' ? 'Wishlist Orders' : 'Orders' }}</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Payement Status</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->created_at->format('h:i:s A') }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->mobile }}</td>
                            <td>{{ $order->address->fullAddress }}</td>
                            <td>
                                <div class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }}">{{ strtoupper($order->payment_status) }}</div>
                            </td>
                            <td>QAR {{ $order->total_amount }}</td>
                            <td>
                                <div class="badge {{ in_array($order->order_status, ['placed', 'cancelled']) ? 'badge-danger' : 'badge-success' }}">{{ strtoupper($order->order_status) }}</div>
                            </td>
                            <td>{{ $order->remarks }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark">Info</button>
                                    <button type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('admin.custOrdersDetails',[encrypt($order->id)])}}"
                                                class="dropdown-item">View</a></li>
                                        <li><a href="#"
                                            class="dropdown-item add-order-remarks"
                                            data-remarks="{{ $order->remarks }}" data-order-id="{{ $order->id }}">Remarks</a></li>
                                        @if($order->order_status == 'placed')

                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'confirmed'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Confirm</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Concelled</a></li>
                                        @elseif($order->order_status == 'confirmed')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'shipped'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Shipped</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Concelled</a></li>
                                        @elseif($order->order_status == 'shipped')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'delivered'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Delivered</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Concelled</a></li>
                                        @elseif($order->order_status == 'delivered')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'returned'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Returned</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to change the status on an order?')">Concelled</a></li>
                                        <li><a href="{{route('admin.returnItems', ['order' => $order->id])}}"
                                                class="dropdown-item">Return Items</a></li>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        $('.add-order-remarks').on('click', function(e) {
            e.preventDefault();
            const url = "{{ route('admin.addOrderRemarks') }}";
            const remarks = $(this).data('remarks');
            const order_id = $(this).data('order-id');
            Swal.fire({
                title: 'Your Remarks',
                inputValue: remarks,
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (remarks) => {
                    return fetch(url, {
                        method: 'post',
                        headers: {"Content-type": "application/json; charset=UTF-8"},
                        body: JSON.stringify({ order_id, remarks })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(response.statusText)
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                        `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Remarks updated successfully',
                        timer: 2000,
                        timerProgressBar: true
                    }).then((result) => {
                        window.location.reload();
                    })
                }
            })
        });
    });
</script>
@endpush
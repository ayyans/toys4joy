@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Abandoned Orders</h6>

        </div>
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-end mb-4">
                <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
                    <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
                <a href="{{ route('admin.abandonedOrders', ['export' => 'true']) }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>
            <div id="filter-container" class="mb-3 border p-3 rounded">
                <div>
                    <a data-start-date="{{ today()->toDateString() }}" href="javascript:;" class="direct-filter d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
                        Today</a>
                    <a data-start-date="{{ today()->subDay()->toDateString() }}" data-end-date="{{ today()->toDateString() }}" href="javascript:;" class="direct-filter d-inline-block btn btn-sm btn-info shadow-sm mr-2" style="width: 120px">
                        Yesterday</a>
                    <a data-start-date="{{ today()->subWeek()->toDateString() }}" href="javascript:;" class="direct-filter d-inline-block btn btn-sm btn-warning shadow-sm mr-2" style="width: 120px">
                        Last Week</a>
                    <a data-start-date="{{ today()->subMonth()->toDateString() }}" href="javascript:;" class="direct-filter d-inline-block btn btn-sm btn-danger shadow-sm mr-2" style="width: 120px">
                        Last Month</a>
                </div>
                <hr>
                <form id="date-filter" action="{{ route('admin.abandonedOrders') }}" method="get">
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
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->end_date }}">
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
                            <td>{{ $order->user_id ? $order->user->name : $order->additional_details['name'] ?? null }}</td>
                            <td>{{ $order->user_id ? $order->user->mobile : $order->additional_details['mobile'] ?? null }}</td>
                            <td>{{ $order->user_id ? $order->address->fullAddress : $order->fullAddress ?? null }}</td>
                            <td>
                                <div class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }}">{{ strtoupper($order->payment_status) }}</div>
                            </td>
                            {{-- <td>{{$order->payment_id}}</td> --}}
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
                                        <li><a href="{{route($order->user_id ? 'admin.custOrdersDetails' : 'admin.guestOrdersDetails',[encrypt($order->id)])}}"
                                                class="dropdown-item">View</a></li>
                                        <li><a href="#"
                                            class="dropdown-item add-order-remarks"
                                            data-remarks="{{ $order->remarks }}" data-order-id="{{ $order->id }}">Remarks</a></li>
                                        @if($order->order_status == 'placed')

                                        {{-- <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'confirmed'])}}"
                                                class="dropdown-item">Confirm</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Cancel</a></li>
                                        @elseif($order->order_status == 'confirmed')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'shipped'])}}"
                                                class="dropdown-item">Shipped</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->order_status == 'shipped')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'delivered'])}}"
                                                class="dropdown-item">Delivered</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->order_status == 'delivered')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Concel</a></li> --}}
                                        {{-- @elseif($order->order_status == 'shipped')
                                        <li><a href="javascript:void(0)" class="dropdown-item">Delivered</a></li> --}}
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
        // filters
        $('#filter-button').on('click', function() {
            $('#filter-container').slideToggle();
        })
        // filter by day
        $('.direct-filter').on('click', function() {
            const start_date = $(this).data('start-date');
            const end_date = $(this).data('end-date');

            $('#start_date').val(start_date);
            $('#end_date').val(end_date);

            $('#date-filter').submit();
        });
        // remarks
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
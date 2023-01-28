@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Third Party Orders</h6>

        </div>
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <a href="{{ route('admin.third-party-orders.create') }}" class="d-inline-block btn btn-sm btn-danger shadow-sm mr-2" style="width: 170px">
                        </i> Add Third Party Order</a>
                </div>
                <div>
                    <a id="filter-button" href="javascript:;" class="d-inline-block btn btn-sm btn-success shadow-sm mr-2" style="width: 120px">
                        <i class="fas fa-filter fa-sm text-white-50"></i> Filter</a>
                    <a href="{{ route('admin.third-party-orders.index', ['export' => 'true']) }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>
            </div>
            <div id="filter-container" class="mb-3 border p-3 rounded">
                <form id="date-filter" action="{{ route('admin.third-party-orders.index') }}" method="get">
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
                            <th>Channel</th>
                            <th>Order Number</th>
                            <th>SKU</th>
                            <th>Quantity</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($thirdPartyOrders as $thirdPartyOrder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::headline($thirdPartyOrder->channel) }}</td>
                            <td>{{ $thirdPartyOrder->order_number }}</td>
                            <td>{{ $thirdPartyOrder->sku }}</td>
                            <td>{{ $thirdPartyOrder->quantity }}</td>
                            <td>{{ $thirdPartyOrder->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark">Info</button>
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('admin.third-party-orders.edit', $thirdPartyOrder->id) }}" class="dropdown-item" onclick="return validatePassword();">Edit</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.third-party-orders.destroy', $thirdPartyOrder->id) }}"
                                                class="dropdown-item text-danger" onclick="event.preventDefault();
                                                    deleteThirdPartyOrder('delete-order-{{ $thirdPartyOrder->id }}')">Delete</a>

                                            <form id="delete-order-{{ $thirdPartyOrder->id }}"
                                                    action="{{ route('admin.third-party-orders.destroy', $thirdPartyOrder->id) }}"
                                                        method="POST" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </li>
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
        });
    });

    function deleteThirdPartyOrder(id) {
        if ( validatePassword() )
        document.getElementById( id ).submit();
    }

    function validatePassword() {
        const password = prompt("Please enter password to proceed ?");

        if ( btoa(password) !== 'cGFzc3dvcmQ=' ) {
            alert('The password you have entered is incorrect!');
            return false;
        }

        return true;
    }
</script>
@endpush
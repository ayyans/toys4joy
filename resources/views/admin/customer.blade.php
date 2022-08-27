@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Customers</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Registration</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->mobile}}</td>
                            <td>
                                @if($customer->status==1)
                                <div class="badge badge-danger">Pending</div>
                                @elseif($customer->status==2)
                                <div class="badge badge-success">Activate</div>
                                @elseif($customer->status==3)
                                <div class="badge badge-danger">Deactivate</div>
                                @endif
                            </td>
                            <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                            {{-- <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark">Info</button>
                                    <button type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">

                                        @if($customer->status==1)
                                        <li><a href="{{route('admin.activateCustomer',[encrypt($customer->id)])}}"
                                                class="dropdown-item">Activate</a></li>

                                        @elseif($customer->status==2)
                                        <li><a href="{{route('admin.deactivateCustomer',[encrypt($customer->id)])}}"
                                                class="dropdown-item">Deactivate</a></li>

                                        @elseif($customer->status==3)
                                        <li><a href="{{route('admin.activateCustomer',[encrypt($customer->id)])}}"
                                                class="dropdown-item">Activate</a></li>

                                        @endif
                                        <li><a href="{{route('admin.deleteCust',[encrypt($customer->id)])}}"
                                                class="dropdown-item">Delete</a></li>
                                    </ul>
                                </div>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
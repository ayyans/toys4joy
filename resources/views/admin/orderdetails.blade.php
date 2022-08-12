@extends('admin.layouts.master')
@section('content')

@php


// DB::table('orders')->where('id' , $order->id)->update(['newstatus'=>0]);

@endphp

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Orders Details</h6>
        </div>
        <div class="card-body">
            <table style="width:100% ;margin-bottom:20px;">
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input type="hidden" name="orderid" id="orderid" value="{{$order->id}}" />
                        <label>Delivery Status</label>
                        {{-- @if($order->status==4 || $order->status==5 ) --}}
                        {{-- <select class="form-control" readonly>
                            <option @if($order->status == 1) selected @endif value="1">Pending</option>
                            <option @if($order->status == 2) selected @endif value="2">Confirm</option>
                            <option @if($order->status == 3) selected @endif value="3">Shipped</option>
                            <option @if($order->status == 4) selected @endif value="4">Cancel</option>
                            <option @if($order->status == 5) selected @endif value="5">Delivered</option>
                        </select>
                        @else --}}
                        <select class="form-control" id="orderStatus">
                            <option @if($order->order_status == 'placed') selected @endif value="placed">Placed</option>
                            <option @if($order->order_status == 'confirmed') selected @endif value="confirmed">Confirmed</option>
                            <option @if($order->order_status == 'shipped') selected @endif value="shipped">Shipped</option>
                            <option @if($order->order_status == 'cancelled') selected @endif value="cancelled">Cancelled</option>
                            <option @if($order->order_status == 'delivered') selected @endif value="delivered">Delivered</option>
                        </select>
                        {{-- @endif --}}
                        <a href="{{ url('generateinvoice') }}/{{ $order->id }}">Download Invoice</a>


                        @if($order->is_wishlist)


                        <button data-toggle="modal" data-target="#greetignmessage" class="btn btn-primary mt-2">View Greeting
                            Message</button>
                        <div class="modal fade" id="greetignmessage">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Greeting Message</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    @php
                                    // $greetingmessage = DB::table('greetingmessages')->where('orderid' ,
                                    // $order->id)->get()->first();

                                    @endphp
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        {{-- @if($greetingmessage) --}}
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $order->additional_details['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number</td>
                                                <td>{{ $order->additional_details['phone'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Message</td>
                                                <td>{{ $order->additional_details['message'] }}</td>
                                            </tr>
                                        </table>
                                        {{-- @endif --}}

                                    </div>

                                    <!-- Modal footer -->


                                </div>
                            </div>
                        </div>
                        @endif
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <h1>toy4joy</h1><br /><br />
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <strong>{{$order->user->name}}</strong><br />
                        <strong> {{$order->user->email}}</strong><br />
                        <strong>{{$order->user->mobile}}</strong><br />
                        <strong>{{ $order->address->unit_no }},{{ $order->address->building_no }},{{ $order->address->zone }},{{ $order->address->street }}
                        </strong>
                    </td>
                    <td style="text-align:justify">
                        <strong>Order Id: {{ $order->order_number }}</strong><br />
                        <strong>Order status:</strong> {{ $order->order_status }}
                        <br />
                        <strong>Order date:</strong>{{ $order->created_at }}<br />
                        <strong>Payment Mode:</strong> {{ $order->order_type }}
                        <br />
                    </td>
                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>sl.no</th>
                            <th>product</th>
                            <th>image</th>
                            <th>Qty</th>
                            <th>Total Amount (in QAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        {{-- @php
                        $product = DB::table('products')->where('id' , $r->product_id)->get()->first();
                        @endphp --}}
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->title }}</td>
                            <td><img src="{{ asset('products/'.$item->product->featured_img) }}" style="width:100px" /></td>
                            <td>{{ $item->quantity }}</td>
                            <td>QAR {{ $item->total_amount }}</td>

                        </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        @php
                        //$total_amount = $order->total_amount;
                        @endphp
                        <!-- <tr>
                            <td colspan="4" style="text-align:right"><strong>Discount(coupon)</strong></td>

                            <td>
                                <?php 
                                $total_amount = $order->total_amount;

                                 ?>
                               {{-- @if($total_amount==$orderdetail->amount)
                                    0
                                    @else
                                    {{$orderdetail->prod_price*$orderdetail->qty-$orderdetail->amount}}

                                    @endif--}}
                            </td>
                            
                        </tr> -->
                        {{-- <?php //$total_price = 0; ?>
                        @foreach(DB::table('order_items')->where('order_id' , $order->id)->get() as $r)
                        @php
                        //$product = DB::table('products')->where('id' , $r->product_id)->get()->first();
                        if($r->discount)
                        {
                        $price = ($r->price-$r->discount);
                        }else{
                        $price = $r->price;
                        }

                        @endphp
                        <?php //$total_price+=$price*$r->quantity; ?>
                        @endforeach --}}

                        <tr>
                            <td colspan="4" style="text-align:right"><strong>Sub Total</strong></td>
                            <td>QAR {{ $order->subtotal }}</td>
                        </tr>


                        @php
                        // $giftcardprijce=0;
                        @endphp
                        {{-- @if($orders->first()->giftcode)

                        @php
                        $usergiftcard = DB::table('usergiftcards')->where('code' ,
                        $orders->first()->giftcode)->get()->first();
                        $giftcard = DB::table('giftcards')->where('id' , $usergiftcard->gift_card_id)->get()->first();

                        $giftcardprice = $total_price-$giftcard->price;

                        if($giftcardprice < 0) { $total_price=0; }else{ $total_price=$giftcardprice; } @endphp <tr
                            class="total">
                            <td colspan="4" style="text-align:right"><strong>Discount Gift Card:</strong></td>
                            <td> QAR {{ $giftcardprice }} </td>
                            <!---<td> QAR {{ $giftcard->price }}  </td>-->
                            </tr>
                            @endif
                            --}}
                            <tr class="giftcard">
                                <td colspan="4" style="text-align:right"><strong>Giftcard Discount:</strong></td>
                                <td colspan="3">QAR {{ $order->giftcards->sum('price') }}</td>
                            </tr>
                            <tr class="coupon">
                                <td colspan="4" style="text-align:right"><strong>Coupon Discount:</strong></td>
                                <td colspan="3">{{ $order->coupon->offer ?? 0 }}%</td>
                            </tr>
                            <tr class="coupon">
                                <td colspan="4" style="text-align:right"><strong>Total Discount:</strong></td>
                                <td colspan="3">QAR {{ $order->discount ?? 0 }}</td>
                            </tr>
                            <tr class="total">
                                <td colspan="4" style="text-align:right"><strong>Total:</strong></td>
                                <td colspan="3">QAR {{ $order->total_amount }}</td>
                            </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop


@push('otherscript')
<script>
    $(function(){
        $("#orderStatus").change(function(){
            var status = $(this).val();
            if (['cancelled', 'delivered'].includes("{{ $order->order_status }}")) return;
            var orderid = $("#orderid").val();
            var form = new FormData();
            form.append('status',status);
            form.append('orderid',orderid);
            $.ajax({
                url:"{{route('admin.CustomerorderStatus')}}",
                type:"POST",
                data:form,
                cache:false,
                contentType:false,
                processData:false,
                success:function(res){
                    var js_data = JSON.parse(res);
                    if(js_data==1){
                        toastr.success('order status changed successfull!');
                                    location.reload();
                    }else{
                        toastr.error('something went wrong');
                                    return false;
                    }
                }
            })
        })
    })
</script>
@endpush
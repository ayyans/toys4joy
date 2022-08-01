@extends('admin.layouts.master')
@section('content')

@php
    

    DB::table('orders')->where('orderid' , $orderdetail->orderid)->update(['newstatus'=>0]);

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
            <input type="hidden" name="orderid" id="orderid" value="{{$orderdetail->id}}" />
            <label>Delivery Status</label>
            @if($orderdetail->status==4 || $orderdetail->status==5 )
            <select class="form-control" readonly>
                <option @if($orderdetail->status == 1) selected @endif value="1">Pending</option>
                <option @if($orderdetail->status == 2) selected @endif value="2">Confirm</option>
                <option @if($orderdetail->status == 3) selected @endif value="3">Shipped</option>
                <option @if($orderdetail->status == 4) selected @endif value="4">Cancel</option>
                <option @if($orderdetail->status == 5) selected @endif value="5">Delivered</option>
            </select>
            @else
            <select class="form-control" id="orderStatus">
                <option @if($orderdetail->status == 1) selected @endif value="1">Pending</option>
                <option @if($orderdetail->status == 2) selected @endif value="2">Confirm</option>
                <option @if($orderdetail->status == 3) selected @endif value="3">Shipped</option>
                <option @if($orderdetail->status == 4) selected @endif value="4">Cancel</option>
                <option @if($orderdetail->status == 5) selected @endif value="5">Delivered</option>
            </select>
            @endif
            <a href="{{ url('generateinvoice') }}/{{ $orderdetail->orderid }}">Download Invoice</a>


            @if($orderdetail->ordertype == 'wishlist')


            <button data-toggle="modal" data-target="#greetignmessage" class="btn btn-primary">View Greeting Message</button>
            <div class="modal fade" id="greetignmessage">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Greeting Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  @php
                    $greetingmessage = DB::table('greetingmessages')->where('orderid' , $orderdetail->orderid)->get()->first();

                  @endphp
                  <!-- Modal body -->
                  <div class="modal-body">
                    @if($greetingmessage)
                    <table class="table table-bordered">
                        <tr>
                            <td>Name</td>
                            <td>{{ $greetingmessage->name }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>{{ $greetingmessage->phonenumber }}</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td>{{ $greetingmessage->message }}</td>
                        </tr>
                    </table>
                    @endif

                  </div>

                  <!-- Modal footer -->


                </div>
              </div>
            </div>
            @endif
        </td>
                  
    </tr>
    <tr>
        <td colspan="2"><h1>toy4joy</h1><br/><br/></td>
    </tr>
    <tr>
        <td colspan="1">
            <strong>{{$orderdetail->name}}</strong><br/>
            <strong> {{$orderdetail->email}}</strong><br/>
            <strong>{{$orderdetail->mobile}}</strong><br/>
            <strong>{{$orderdetail->unit_no}},{{$orderdetail->building_no}},{{$orderdetail->zone}},{{$orderdetail->street}} </strong>
        </td>
        <td style="text-align:justify">
            <strong>Order Id:{{ $orderdetail->orderid }}</strong><br/>
            <strong>Order status:</strong> @if($orderdetail->status==1)
            Pending
            @elseif($orderdetail->status==2)
            Confirm
            @elseif($orderdetail->status==3)
            shipped
            @elseif($orderdetail->status==4)
            Cancelled
            @elseif($orderdetail->status==5)
            delivered
            @endif
            <br/>
            <strong>Order date:</strong>{{$orderdetail->created_at}}<br/>
            <strong>Payment Mode</strong>: @if($orderdetail->mode==2)Online
            @else
            COD
            @endif
            <br/>
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
                    <th>Total Amount (in AED)</th>              
                </tr>
            </thead>
            
            <tbody>
                @foreach($orders as $r)
                @php
                  $product = DB::table('products')->where('id' , $r->product_id)->get()->first();
                @endphp
                <tr>
                    <td>1</td>
                    <td>{{ $product->title }}</td>
                    <td><img src="{{asset('products/'.$product->featured_img)}}" style="width:100px"/></td>
                    <td>{{$orderdetail->qty}}</td>
                    <td>QAR {{$r->prod_price*$r->qty}}</td>
                   
                </tr>
                @endforeach
             
            </tbody>
            <tfoot>
                        <!-- <tr>
                            <td colspan="4" style="text-align:right"><strong>Discount(coupon)</strong></td>

                            <td>
                                <?php 
                                $total_amount = $orderdetail->prod_price*$orderdetail->qty;

                                 ?>
                                @if($total_amount==$orderdetail->amount)
                                    0
                                    @else
                                    {{$orderdetail->prod_price*$orderdetail->qty-$orderdetail->amount}}

                                    @endif
                            </td>
                            
                        </tr> -->
                        <?php $total_price = 0; ?>
                        @foreach(DB::table('orders')->where('orderid' , $orderdetail->orderid)->get() as $r)
                        @php
                          $product = DB::table('products')->where('id' , $r->prod_id)->get()->first();
                          if($product->discount)
                          {
                              $price = $product->discount;
                          }else{
                              $price = $product->unit_price;
                          }

                        @endphp
                        @endforeach
                        <?php $total_price+=$price*$r->qty; ?>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>Total</strong></td>
                            <td>QAR {{ $total_price }}</td>
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
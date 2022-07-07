@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
   
<div class="card shadow mb-4">

<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">All Guest Orders Details</h6>
    
</div>
<div class="card-body">
<table style="width:100% ;margin-bottom:20px;">
                <tr>
                    <td colspan="2"></td>
                  
                    <td>
                        <input type="hidden" name="orderid" id="orderid" value="{{$orders->id}}" />
                        <label>Delivery Status</label>
                        @if($orders->status==4 || $orders->status==5 )
                        <select class="form-control" readonly>
                            <option value="1">Pending</option>
                            <option value="2">Confirm</option>
                            <option value="3">Shipped</option>
                            <option value="4">Cancel</option>
                            <option value="5">Delivered</option>
                        </select>
                        @else
                        <select class="form-control" id="orderStatus">
                            <option value="1">Pending</option>
                            <option value="2">Confirm</option>
                            <option value="3">Shipped</option>
                            <option value="4">Cancel</option>
                            <option value="5">Delivered</option>
                        </select>
                        @endif


                        <a href="{{ url('generateinvoice') }}/{{ $orders->order_id }}">Download Invoice</a>
                    </td>
                  
                </tr>
                <tr>
                    <td colspan="2"><h1>toy4joy</h1><br/><br/></td>
                   
                </tr>
                <tr>
                    <td colspan="1">
                        <strong>{{$orders->cust_name}}</strong><br/>
                        <strong> {{$orders->cust_email}}</strong><br/>
                        <strong>{{$orders->cust_mobile}}</strong><br/>
                       
                </td>
                <td style="text-align:justify">
                    <strong>Order Id:{{ $orders->order_id }}</strong><br/>
                    <strong>Order status:</strong> @if($orders->status==1)
                    <b style="color:red;"> Pending </b>
                    @elseif($orders->status==2)
                    <b style="color:red;"> Conferm</b>
                    @elseif($orders->status==3)
                    shipped
                    @elseif($orders->status==4)
                    Cancelled
                    @elseif($orders->status==5)
                    delivered
                    @endif
                    <br/>
                    <strong>Order date:</strong> {{date('d M Y', strtotime($orders->created_at))}} <br/>
                    <strong>Order Time:</strong> {{date('h:i:s A', strtotime($orders->created_at))}} <br/>
                    <strong>Payment Mode</strong>: <b style="color: green;"> @if($orders->mode==1)
                    PAID
                    @else
                    COD
                    @endif
                    </b>
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
                    <th>Total Amount (in QAR)</th>                                                                                  
                                      
                </tr>
            </thead>
            
            <tbody>
             
                <tr>
                    <td>1</td>
                    <td>{{$orders->productName}}</td>
                    <td><img src="{{asset('products/'.$orders->featured_img)}}" style="width:100px"/></td>
                    <td>{{$orders->qty}}</td>
                    <td>{{$orders->prod_price*$orders->qty}}</td>
                   
                </tr>
              
             
            </tbody>
            <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>Subtotal</strong></td>
                            <td>{{$orders->prod_price*$orders->qty}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>total</strong></td>
                            <td>{{$orders->prod_price*$orders->qty}}</td>
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
                url:"{{route('admin.orderStatus')}}",
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
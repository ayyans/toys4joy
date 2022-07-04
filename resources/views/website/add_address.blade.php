@extends('website.layouts.master')
@section('content')
<main id="add-change-address" class="address-information">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 left-col">
                <div class="guest">
                    <a href="javascript:void(0)" id="saveAddress">Add Address</a>
                </div>
                <div class="guest">
                    <a href="javascript:void(0)" id="updateAddress">Change Address</a>
                </div>
            </div>
            @php

              $address =  DB::table('customer_addresses')->where('cust_id' , Auth::user()->id)->get()->first();

            @endphp
            <div class="col-6 right-col">
             <form action="#" id="addressFrm">
                <div class="form-group">
                    <div class="form-inner">
                        <div class="input-block unit-num">
                            <label>Unit Number</label>
                            <input @if($address) value="{{ $address->unit_no }}" @endif type="text" name="unit_no" class="cust_address">
                        </div>
                        <div class="input-block building-num">
                            <label>Building Number</label>
                            <input @if($address) value="{{ $address->building_no }}" @endif type="text" name="buid_no" class="cust_address">
                        </div>
                        <div class="d-flex zone-street">
                            <div class="input-block zone">
                                <label>Zone</label>
                                <input @if($address) value="{{ $address->zone }}" @endif type="text" name="zone"  class="cust_address">
                            </div>
                            <div class="input-block street">
                                <label>Street</label>
                                <input @if($address) value="{{ $address->street }}" @endif type="text" name="street" class="cust_address">
                            </div>
                        </div>    
                    </div>
                </div>
            </form>
                <div class="d-flex google-location">
                    <img src="{{asset('website/img/location.png')}}">
                    <div class="guest"><a href="javascript:void(0)">Add Google Location</a></div>
                </div>
            </div>
       </div>      
    </div>
</main>
    


@stop

@push('otherscript')

<script>
    $(function(){
        $("a#saveAddress").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.cust_address').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

        if(isValid!=true){
           
            return false;
        }else{
            
            $("#cover-spin").show();
            var form = $("form#addressFrm")[0];
            var form2 = new FormData(form);
            $.ajax({
                url:"{{route('website.addAddressProcess')}}",
                type:"POST",
                data:form2,
                cache:false,
                contentType:false,
                processData:false,
                success:function(res){
                    $("#cover-spin").hide();
                    var js_data = JSON.parse(res);
                    if(js_data==1){
                        toastr.success('customer address added');
                        location.reload();
                    }else{
                        toastr.error('something went wrong');
                        return false;
                    }
                }
            })

        }

        })
    })
</script>
@endpush
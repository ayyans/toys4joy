@extends('website.layouts.master')
@section('content')

<main id="pay-as-guest">
<div class="container-fluid">
    <div class="row">
    	<div class="col-3"></div>
        <div class="col-6 text-center">
            <div class="select-credit-card">
                <h4>Select Your Credit Card</h4>
                <form id="cardinfoFrm" action="#">
                <div class="payment-opt">
                    <div class="form-check form-check-inline visa">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                      <label class="form-check-label" for="inlineRadio1"><img for="inlineRadio1" src="{{asset('website/img/visa.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline master-card">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                      <label class="form-check-label" for="inlineRadio2"><img for="inlineRadio2" src="{{asset('website/img/master-card.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline american-express">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3">
                      <label class="form-check-label" for="inlineRadio3"><img for="inlineRadio3" src="{{asset('website/img/american-express.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline discover">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="4">
                      <label class="form-check-label" for="inlineRadio4"><img for="inlineRadio4" src="{{asset('website/img/discover.png')}}"/></label>
                    </div>
                </div>
                <div class="row card-info">
                <div class="col-8">
                    <div class="mb-3">
                	<label>Cardholder's Name <span style="color:#ff0000">*</span></label>
                	<input type="text" name="card_holder" class="carddetails">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                	<label>Card Number <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-number" maxlength="16" name="card_no">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                	<label>Expiry Month <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-expiry-month" placeholder="MM" maxlength="2" name="card_exp_month">
                    </div>
                </div>
                <div class="col-4">
                <div class="mb-3">
                	<label>Expiry year <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-expiry-year" placeholder="YYYY" maxlength="4" name="card_exp_year">
                    </div>
                </div>
                <div class="col-4">
                    <label>Security code <span style="color:#ff0000">*</span></label>
                    <div class="d-flex security-field">               
                        <input type="text" class="carddetails card-cvc" maxlength="3" name="cvv">
                        <img src="{{asset('website/img/cvv.png')}}"/>
                    </div>
                </div>
                <div class="btn pinkbg-img update">
                    <a href="javascript:void(0)" id="cardinfoBtn">Update</a>
                </div>
            </div>
            </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>

    

</main>

@stop

@push('otherscript')
<script>

$("#cardinfoBtn").click(function(e){

e.preventDefault();
  
var isValid = true;
$("input.carddetails").each(function(){
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
    e.preventDefault();
    return false;
}else{
    $("#cover-spin").show();
    var form = $("form#cardinfoFrm")[0];
    var form2 = new FormData(form);
    $.ajax({
        url:"{{route('website.Usercardinfo')}}",
        type:"POST",
        data:form2,
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            $("#cover-spin").hide();
            var js_data = JSON.parse(JSON.stringify(res));
            if(js_data.status==200){
                toastr.success('Card info added');
                location.reload();
            }else{
                toastr.error('something went wrong');
                return false;
            }
        }
    })
}
})

</script>


@endpush
@extends('website.layouts.master')
@section('content')
@php
  $address =  DB::table('customer_addresses')->where('cust_id' , Auth::user()->id)->get()->first();
@endphp
<style type="text/css">
    #map{
    width: 100%;
    height: 500px;
}
</style>

<main id="add-change-address" class="address-information">
    <div class="container-fluid">
        <div class="row">
        
            <div class="col-6 left-col">
                <!-- Search input -->
            <input id="searchInput" class="controls form-control" type="text" placeholder="Enter a location">

            <!-- Google map -->
            <div id="map"></div>
            </div>

            
            <div class="col-6 right-col">
             <form action="#" id="addressFrm">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
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
                    <div class="guest"><a href="javascript:void(0)" id="saveAddress">Save Address</a></div>
                </div>
            </div>
       </div>      
    </div>
</main>
    


@stop

@push('otherscript')
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: {{$address->latitude}}, lng: {{$address->longitude}}},
      zoom: 13
    });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
    
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAe9WMf4KmWxB4K1O_j-q1jYuolIKcU3_0&callback=initMap" async defer></script>

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
                        toastr.success('Address Save Succssfully');
                        // location.reload();
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
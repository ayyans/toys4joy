@extends('website.layouts.master')
@section('content')
@php
  $address =  DB::table('customer_addresses')->where('cust_id' , Auth::user()->id)->get()->first();
@endphp
<style type="text/css">
    #mapid{
    width: 100%;
    height: 500px;
}
</style>

<main id="add-change-address" class="address-information">
    <div class="container-fluid">
        <div class="row">
        
            <div class="col-6 left-col">
                    <!-- Search input -->
                <input style="max-width: 60%;margin: auto;" id="pac-input" class="controls form-control" type="text" placeholder="Search Place"/>
                <div id="mapid"></div>
            </div>
            
            <div class="col-6 right-col">
             <form action="#" id="addressFrm">
                <input type="hidden" name="latitude" id="latitude" value="{{ $latitude }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ $longitude }}">
                <div class="form-group">
                    <div class="form-inner">
                        <div class="input-block unit-num">
                            <label>{{__('trans.Unit Number')}}</label>
                            <input @if($address) value="{{ $address->unit_no }}" @endif type="text" name="unit_no" class="cust_address">
                        </div>
                        <div class="input-block building-num">
                            <label>{{__('trans.Building Number')}}</label>
                            <input @if($address) value="{{ $address->building_no }}" @endif type="text" name="buid_no" class="cust_address">
                        </div>
                        <div class="d-flex zone-street">
                            <div class="input-block zone">
                                <label>{{__('trans.Zone')}}</label>
                                <input @if($address) value="{{ $address->zone }}" @endif type="text" name="zone"  class="cust_address">
                            </div>
                            <div class="input-block street">
                                <label>{{__('trans.Street')}}</label>
                                <input @if($address) value="{{ $address->street }}" @endif type="text" name="street" class="cust_address">
                            </div>
                        </div>    
                    </div>
                </div>
            </form>
                <div class="d-flex google-location">
                    <div class="guest"><a href="javascript:void(0)" id="saveAddress">{{__('trans.Save Address')}}</a></div>
                </div>
            </div>
       </div>      
    </div>
</main>
    


@stop

@push('otherscript')
<script>
function initAutocomplete() {
const map = new google.maps.Map(document.getElementById("mapid"), {
  center: { lat: {{$latitude}}, lng: {{ $longitude }} },
  zoom: 13,
  mapTypeId: "roadmap",
});
const myLatlng = { lat: {{$latitude}}, lng: {{ $longitude }} };
marker = new google.maps.Marker({
    position: myLatlng,
    map: map
});
// Create the search box and link it to the UI element.
const input = document.getElementById("pac-input");

const searchBox = new google.maps.places.SearchBox(input);
map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// Bias the SearchBox results towards current map's viewport.
map.addListener("bounds_changed", () => {
  searchBox.setBounds(map.getBounds());
});
let markers = [];
// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener("places_changed", () => {
  const places = searchBox.getPlaces();

  if (places.length == 0) {
    return;
  }
  // Clear out the old markers.
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  markers = [];
  // For each place, get the icon, name and location.
  const bounds = new google.maps.LatLngBounds();
  places.forEach((place) => {
    if (!place.geometry || !place.geometry.location) {
      console.log("Returned place contains no geometry");
      return;
    }
    const icon = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25),
    };
    // Create a marker for each place.
    markers.push(
      new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
      })
    );

    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
  });
  map.fitBounds(bounds);
});
}
</script>

<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe9WMf4KmWxB4K1O_j-q1jYuolIKcU3_0&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
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

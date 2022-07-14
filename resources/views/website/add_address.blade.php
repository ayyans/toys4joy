@extends('website.layouts.master')
@section('content')
<main id="add-change-address" class="address-information">
    <div class="container-fluid">
        <div class="row">
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe9WMf4KmWxB4K1O_j-q1jYuolIKcU3_0">
    </script>
            <style type="text/css">
                #map {
                  height: 100%;
                }
                #description {
                  font-family: Roboto;
                  font-size: 15px;
                  font-weight: 300;
                }

                #infowindow-content .title {
                  font-weight: bold;
                }

                #infowindow-content {
                  display: none;
                }

                #map #infowindow-content {
                  display: inline;
                }

                .pac-card {
                  background-color: #fff;
                  border: 0;
                  border-radius: 2px;
                  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                  margin: 10px;
                  padding: 0 0.5em;
                  font: 400 18px Roboto, Arial, sans-serif;
                  overflow: hidden;
                  font-family: Roboto;
                  padding: 0;
                }

                #pac-container {
                  padding-bottom: 12px;
                  margin-right: 12px;
                }

                .pac-controls {
                  display: inline-block;
                  padding: 5px 11px;
                }

                .pac-controls label {
                  font-family: Roboto;
                  font-size: 13px;
                  font-weight: 300;
                }

                #pac-input {
                  background-color: #fff;
                  font-family: Roboto;
                  font-size: 15px;
                  font-weight: 300;
                  margin-left: 12px;
                  padding: 0 11px 0 13px;
                  text-overflow: ellipsis;
                  width: 400px;
                }

                #pac-input:focus {
                  border-color: #4d90fe;
                }

                #title {
                  color: #fff;
                  background-color: #4d90fe;
                  font-size: 25px;
                  font-weight: 500;
                  padding: 6px 12px;
                }

                #target {
                  width: 345px;
                }

            </style>
            <script type="text/javascript">
               
                function initialize() {

                  var markers = [];
                  var map = new google.maps.Map(document.getElementById('map'), {
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  });

                  var defaultBounds = new google.maps.LatLngBounds(
                      new google.maps.LatLng(-33.8902, 151.1759),
                      new google.maps.LatLng(-33.8474, 151.2631));
                  map.fitBounds(defaultBounds);

                  // Create the search box and link it to the UI element.
                  var input = /** @type {HTMLInputElement} */(
                      document.getElementById('pac-input'));
                  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                  var searchBox = new google.maps.places.SearchBox(
                    /** @type {HTMLInputElement} */(input));

                  // [START region_getplaces]
                  // Listen for the event fired when the user selects an item from the
                  // pick list. Retrieve the matching places for that item.
                  google.maps.event.addListener(searchBox, 'places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                      return;
                    }
                    for (var i = 0, marker; marker = markers[i]; i++) {
                      marker.setMap(null);
                    }

                    // For each place, get the icon, place name, and location.
                    markers = [];
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0, place; place = places[i]; i++) {
                      var image = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                      };

                      // Create a marker for each place.
                      var marker = new google.maps.Marker({
                        map: map,
                        icon: image,
                        title: place.name,
                        position: place.geometry.location
                      });

                      markers.push(marker);

                      bounds.extend(place.geometry.location);
                    }

                    map.fitBounds(bounds);
                  });
                  // [END region_getplaces]

                  // Bias the SearchBox results towards places that are within the bounds of the
                  // current map's viewport.
                  google.maps.event.addListener(map, 'bounds_changed', function() {
                    var bounds = map.getBounds();
                    searchBox.setBounds(bounds);
                  });
                }

                google.maps.event.addDomListener(window, 'load', initialize);


            </script>
            <div class="col-6 left-col">
                <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
                <div id="map"></div>
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
                    <div class="guest"><a href="javascript:void(0)" id="saveAddress">Save Address</a></div>
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
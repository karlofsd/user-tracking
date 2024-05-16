@extends('layout.app')
@section('content')
    <?php
    $user = Auth::user();
    $location = $user->location;
    
    $hasLocation = $location != null;
    ?>
    <div class="d-flex w-100 align-items-center justify-content-center"
        style="flex-direction:column; row-gap:24px; min-height:inherit">
        <header class="w-100">
            <nav class="navbar navbar-expand-sm navbar-light bg-light w-100" style="position: relative">
                <div class="container">
                    <a class="navbar-brand" href="#">UserTracking</a>
                    <div class="collapse navbar-collapse d-flex" id="collapsibleNavId" style="column-gap: 16px">
                        <form class="d-flex my-2 my-lg-0 justify-content-center" style="column-gap: 8px; flex:1">
                            <div style="flex: 1; max-width:600px">
                                <input class="form-control me-sm-2" id="address" type="text" placeholder="Search" />
                                <div class="nav-item dropdown">
                                    <a href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"></a>
                                    <div class="dropdown-menu w-100" id="address-list" aria-labelledby="dropdownId">

                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-success my-2 my-sm-0" id="search" type="button">
                                Search
                            </button>
                        </form>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input name="" id="" class="btn btn-danger" type="submit" value="Logout" />
                        </form>
                    </div>
                </div>
            </nav>

        </header>
        <div style="gap: 16px;
        margin: 0;
        align-items: center;
        flex: 1;
        justify-content: center; flex-direction:column"
            class="d-flex w-100">
            <div id="map" class="w-100" style="height: 400px; border-radius: 16px; max-width:800px"></div>
            <div class="w-100" style=" flex:1;max-width:800px">
                <form id="address_detail" method="POST" action="{{ url('/locations/user/' . $user->id) }}">
                    @csrf
                    <div class="row gx-4 gy-2 m-0" style="align-items: center; flex-wrap:wrap">
                        <div class="mb-3" style="flex: 2; min-width:350px">
                            <label for="" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" readonly id=""
                                aria-describedby="helpId" placeholder="" />
                        </div>

                        <div class="mb-3" style="flex: 1; min-width:200px">
                            <label for="" class="form-label">Locality</label>
                            <input type="text" class="form-control" name="locality" readonly id=""
                                aria-describedby="helpId" placeholder="" />
                        </div>

                        <div class="mb-3" style="flex: 1; min-width:200px">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" readonly id="city"
                                aria-describedby="helpId" placeholder="" />
                        </div>


                        <input type="hidden" class="form-control" name="latitude" readonly id="latInput"
                            value="{{ $hasLocation ? $location->latitude : '' }}" />



                        <input type="hidden" class="form-control" name="longitude" readonly id="lngInput"
                            value="{{ $hasLocation ? $location->longitude : '' }}" />


                    </div>

                    <div class="row justify-content-center m-0 py-2">

                        <input style="max-width: 200px" name="" id="save_address_btn" class="btn btn-success"
                            type="submit" value="Save" />

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGsHPY0qXi_0DYDTaLKmSl6T_x9Nnm5rI&callback=initMap"></script>
    <script>
        let map;
        async function initMap() {
            //@ts-ignore
            const lat = document.getElementById('latInput').value
            const lng = document.getElementById('lngInput').value
            console.log(lat, lng)
            const {
                Map
            } = await google.maps.importLibrary("maps");

            const {
                Marker
            } = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map"), {
                center: {
                    lat: parseFloat(lat) ?? 0,
                    lng: parseFloat(lng) ?? 0
                },
                zoom: 8,
            });

            const marker = new Marker({
                map: map,
                position: map.center,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: 'Uluru'
            });
            var geocoder = new google.maps.Geocoder();
            if ((lat == "" || lng == "") && navigator.geolocation) {
                await navigator.geolocation.getCurrentPosition((position) => {

                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos)
                    marker.setPosition(pos)
                })
            }
            geocodeLatLng(geocoder, map.center)

            map.addListener('click', function(event) {
                const newPos = {
                    lat: parseFloat(event.latLng.lat().toFixed(6)),
                    lng: parseFloat(event.latLng.lng().toFixed(6))
                }

                geocodeLatLng(geocoder, newPos)

                marker.setPosition(newPos)
                map.overlayMapTypes.clear()
            });

            marker.addListener('dragend', function(event) {
                const newPos = {
                    lat: parseFloat(event.latLng.lat().toFixed(6)),
                    lng: parseFloat(event.latLng.lng().toFixed(6))
                }
                geocodeLatLng(geocoder, newPos)
                marker.setPosition(newPos)
                map.overlayMapTypes.clear()
            })




            document.getElementById('search').addEventListener('click', function() {
                geocodeAddress(geocoder, map, marker);
            });

        }

        function geocodeAddress(geocoder, resultsMap, marker) {

            var address = document.getElementById('address').value;
            var list = document.getElementById('address-list');
            var handler = document.getElementById('dropdownId');

            var form = document.getElementById('address_detail')
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    console.log(results)
                    for (var index in results) {
                        var el = document.createElement('a')
                        el.className = 'dropdown-item'
                        el.textContent = results[index].formatted_address
                        el.addEventListener('click', function(e) {
                            const result = parseAddressResults(results[index])
                            form.elements.address.value = result.address
                            form.elements.locality.value = result.locality ?? result.colloquial_area
                            form.elements.city.value = result.administrative_area_level_1
                            form.elements.latitude.value = result.location.lat
                            form.elements.longitude.value = result.location.lng
                            resultsMap.setCenter(results[0].geometry.location);
                            marker.setPosition(results[0].geometry.location)
                        })
                        console.log(index, el)
                        list.append(el)
                    }
                    handler.click();

                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        function geocodeLatLng(geocoder, location) {
            var address = document.getElementById('address')
            var form = document.getElementById('address_detail')
            geocoder.geocode({
                location: location
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const result = parseAddressResults(results[0])
                    form.elements.address.value = result.address
                    form.elements.locality.value = result.locality
                    form.elements.city.value = result.administrative_area_level_1
                    form.elements.latitude.value = result.location.lat
                    form.elements.longitude.value = result.location.lng
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            })
        }

        function parseAddressResults(result) {
            var map = {
                address: result.formatted_address,
                location: {
                    lat: result.geometry.location.lat(),
                    lng: result.geometry.location.lng()
                }
            }
            console.log(result.address_components)
            for (var component of result.address_components) {
                map[component.types[0]] = component.long_name
            }
            console.log(map)
            return map
        }
    </script>
@endsection

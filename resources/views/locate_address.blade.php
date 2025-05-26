{{-- filepath: resources/views/locate_address.blade.php --}}
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Locate Address</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Billing-Table-with-Add-Row--Fixed-Header-Feature.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/dh-row-titile-text-image-right-1.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJG45QmDHbTK6Z1lmcLER74Mzo9mQxXug&libraries=places"></script>
    <style>
        body {
            background-color: #F8F9FA !important;
        }

        #map {
            height: 400px;
            width: 100%;
        }

        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container" style="margin-top: 82px;">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-link p-0 me-2"
                        style="font-size: 1.5rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="text-center mb-0" style="flex: 1;">Locate Your Address</h3>
                </div>
                <!-- Search Box -->
                <input id="search-box" class="form-control search-box" type="text" placeholder="Search for a location">
                <div id="map"></div>
                <div class="mt-3">
                    <h5>Delivery Fee: <span id="delivery-fee">₱20.00</span></h5>
                </div>
                <form action="{{ route('orders.saveAddress') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" id="address" name="address">
                    <input type="hidden" id="delivery-fee-input" name="delivery_fee" value="20">
                    <button type="submit" class="btn btn-primary d-block w-100" style="background: #4ac9b0;">Confirm
                        Address</button>
                </form>
            </div>
        </section>
    </main>
    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'info',
                    title: 'Verify Address',
                    text: '{{ session('status') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    @if(session('address_confirmed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Address Confirmed',
                    text: '{{ session('address_confirmed') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <script>
        let map, marker, geocoder, autocomplete;

        const shopLocation = { lat: 6.41154, lng: 125.60835 }; // Shop's location

        function initMap() {
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById("map"), {
                center: shopLocation, // Default to the shop's location
                zoom: 15,
            });

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: shopLocation,
            });

            // Add autocomplete to the search box
            const searchBox = document.getElementById("search-box");
            autocomplete = new google.maps.places.Autocomplete(searchBox);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", function () {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    alert("No details available for the selected location.");
                    return;
                }

                // Move the map and marker to the selected location
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                marker.setPosition(place.geometry.location);

                // Update the address field
                document.getElementById("address").value = place.formatted_address || place.name;

                // Calculate the distance and update the delivery fee
                calculateDistance(place.geometry.location);
            });

            // Update the address field and calculate distance when the marker is dragged
            google.maps.event.addListener(marker, "dragend", function () {
                const position = marker.getPosition();
                geocodePosition(position);
                calculateDistance(position);
            });
        }

        function geocodePosition(position) {
            geocoder.geocode({ location: position }, function (results, status) {
                if (status === "OK" && results[0]) {
                    document.getElementById("address").value = results[0].formatted_address;
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }

        function calculateDistance(destination) {
            const service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins: [shopLocation],
                    destinations: [destination],
                    travelMode: google.maps.TravelMode.DRIVING,
                },
                function (response, status) {
                    if (status === "OK") {
                        const distanceInMeters = response.rows[0].elements[0].distance.value; // Distance in meters
                        const distanceInKm = distanceInMeters / 1000; // Convert to kilometers

                        // Calculate the delivery fee
                        let deliveryFee = 20; // Base fee for 2km
                        if (distanceInKm > 2) {
                            deliveryFee += Math.ceil(distanceInKm - 2) * 5; // Add 5 PHP for every km beyond 2km
                        }

                        // Display the delivery fee
                        document.getElementById("delivery-fee").textContent = `₱${deliveryFee.toFixed(2)}`;

                        // Update the hidden input field for the delivery fee
                        document.getElementById("delivery-fee-input").value = deliveryFee.toFixed(2);
                    } else {
                        alert("Distance calculation failed due to: " + status);
                    }
                }
            );
        }

        window.onload = initMap;
    </script>
</body>

</html>
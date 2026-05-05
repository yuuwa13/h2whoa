{{-- filepath: resources/views/locate_address.blade.php --}}
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Locate Your Address</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script nonce="{{ csp_nonce() }}" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
    <style nonce="{{ csp_nonce() }}">
        :root {
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
            --brand-light: #e8f8f5;
            --dark: #1a1a2e;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .locate-page { padding: 6rem 0 4rem; display: flex; justify-content: center; }
        .locate-container { width: 100%; max-width: 720px; padding: 0 1rem; }
        .page-title { font-family: 'Montserrat', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--dark); letter-spacing: .04em; margin: 0; white-space: nowrap; flex: 1; text-align: center; }
        
        .btn-back { background: none; border: none; color: var(--brand); font-size: 1.5rem; cursor: pointer; transition: color .2s; margin-right: 1rem; padding: 0; }
        .btn-back:hover { color: var(--brand-dark); }

        /* Card */
        .address-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; }
        .card-section { margin-bottom: 1.5rem; }
        .section-label { font-family: 'Montserrat', sans-serif; font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; margin-bottom: 1rem; border-bottom: 2px solid var(--brand); padding-bottom: .6rem; }

        /* Search Box */
        .search-box { border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 1rem; font-family: 'Poppins', sans-serif; font-size: .95rem; transition: all .2s; }
        .search-box:focus { border-color: var(--brand); outline: none; box-shadow: 0 0 0 3px rgba(74,201,176,.15); }

        /* Map */
        #map { height: 350px; width: 100%; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; }

        /* Delivery Fee Section */
        .fee-section { background: var(--brand-light); border: 1px solid var(--brand); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .fee-label { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748b; margin-bottom: .5rem; }
        .fee-value { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--brand); }

        /* Buttons */
        .btn-container { display: flex; gap: 1rem; }
        .btn-back-address { background: #f1f5f9; color: var(--dark); border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: 1rem 1.5rem; border-radius: 8px; cursor: pointer; transition: all .2s; flex: 0; white-space: nowrap; display: flex; align-items: center; gap: .5rem; text-decoration: none; }
        .btn-back-address:hover { background: #e2e8f0; }
        .btn-confirm-address { background: var(--brand); color: #fff; border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: 1rem 1.5rem; border-radius: 8px; cursor: pointer; transition: background .2s; flex: 1; }
        .btn-confirm-address:hover { background: var(--brand-dark); }
        .btn-confirm-address:disabled { opacity: .5; cursor: not-allowed; }
    </style>
</head>

<body>
    <main class="locate-page">
        <div class="locate-container">
            <div class="d-flex align-items-center mb-4">
                <h1 class="page-title" style="margin: 0;">Locate Your Address</h1>
            </div>

            <div class="address-card">
                <!-- Search Section -->
                <div class="card-section">
                    <div class="section-label">Search Location</div>
                    <input id="search-box" class="search-box w-100" type="text" placeholder="Search for a location or address...">
                </div>

                <!-- Map Section -->
                <div class="card-section">
                    <div class="section-label">Map</div>
                    <div id="map"></div>
                    <div class="small text-muted" style="margin-top: .5rem;">Drag the marker to adjust your location or search above</div>
                </div>

                <!-- Delivery Fee Section -->
                <div class="fee-section">
                    <div class="fee-label">Estimated Delivery Fee</div>
                    <div class="fee-value">₱<span id="delivery-fee">20.00</span></div>
                </div>

                <!-- Confirm Button -->
                <form id="address-form" action="{{ route('orders.saveAddress') }}" method="POST">
                    @csrf
                    <input type="hidden" id="address" name="address">
                    <input type="hidden" id="delivery-fee-input" name="delivery_fee" value="20">
                    
                    <div class="btn-container">
                        <a href="{{ route('orders.index') }}" class="btn-back-address">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn-confirm-address" id="confirm-btn" disabled>
                            <i class="fas fa-check"></i> Confirm Address
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @if(session('status'))
        <script nonce="{{ csp_nonce() }}">
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
        <script nonce="{{ csp_nonce() }}">
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

    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script nonce="{{ csp_nonce() }}">
        let map, marker, geocoder, autocomplete;
        const shopLocation = { lat: 6.41154, lng: 125.60835 };
        const confirmBtn = document.getElementById('confirm-btn');

        function initMap() {
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById("map"), {
                center: shopLocation,
                zoom: 15,
            });

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: shopLocation,
            });

            const searchBox = document.getElementById("search-box");
            autocomplete = new google.maps.places.Autocomplete(searchBox);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", function () {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    Swal.fire({ icon: 'error', title: 'Invalid Location', text: 'No details available for the selected location.', toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000 });
                    return;
                }

                map.setCenter(place.geometry.location);
                map.setZoom(15);
                marker.setPosition(place.geometry.location);
                document.getElementById("address").value = place.formatted_address || place.name;
                confirmBtn.disabled = false;
                calculateDistance(place.geometry.location);
            });

            google.maps.event.addListener(marker, "dragend", function () {
                const position = marker.getPosition();
                geocodePosition(position);
                confirmBtn.disabled = false;
                calculateDistance(position);
            });
        }

        function geocodePosition(position) {
            geocoder.geocode({ location: position }, function (results, status) {
                if (status === "OK" && results[0]) {
                    document.getElementById("address").value = results[0].formatted_address;
                } else {
                    Swal.fire({ icon: 'error', title: 'Geocoding Error', text: 'Could not retrieve address: ' + status, toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000 });
                }
            });
        }

        function calculateDistance(destination) {
            const service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [shopLocation],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
            }, function (response, status) {
                if (status === "OK") {
                    const distanceInMeters = response.rows[0].elements[0].distance.value;
                    const distanceInKm = distanceInMeters / 1000;
                    let deliveryFee = 20;
                    if (distanceInKm > 2) {
                        deliveryFee += Math.ceil(distanceInKm - 2) * 5;
                    }
                    document.getElementById("delivery-fee").textContent = deliveryFee.toFixed(2);
                    document.getElementById("delivery-fee-input").value = deliveryFee.toFixed(2);
                } else {
                    Swal.fire({ icon: 'error', title: 'Distance Calculation Failed', text: 'Status: ' + status, toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000 });
                }
            });
        }

        window.onload = initMap;
    </script>
</body>

</html>
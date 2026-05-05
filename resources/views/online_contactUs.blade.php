@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<style nonce="{{ csp_nonce() }}">
    .contact-page { padding: 3rem 0 8rem; }

    /* Page header */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    .page-header .eyebrow {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #4ac9b0;
        margin-bottom: .5rem;
    }
    .page-header h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: .5rem;
    }
    .page-header p {
        font-size: .9rem;
        color: #888;
        max-width: 440px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* Map */
    #map {
        width: 100%;
        height: clamp(200px, 30vh, 340px);
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* Contact card */
    .contact-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 2.5rem 2rem;
    }
    .contact-card h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 1.75rem;
        padding-bottom: .75rem;
        border-bottom: 2px solid #4ac9b0;
    }
    .form-label-custom {
        font-size: .8rem;
        font-weight: 600;
        color: #555;
        margin-bottom: .35rem;
    }
    .form-control-custom {
        width: 100%;
        padding: .65rem 1rem;
        font-size: .9rem;
        font-family: 'Poppins', sans-serif;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        background: #fff;
        color: #1a1a2e;
    }
    .form-control-custom:focus {
        border-color: #4ac9b0;
        box-shadow: 0 0 0 3px rgba(74,201,176,.15);
    }
    textarea.form-control-custom { resize: vertical; min-height: 140px; }
    .form-group-custom { margin-bottom: 1.25rem; }

    .btn-send {
        background: #4ac9b0;
        border: none;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        letter-spacing: .06em;
        padding: .85rem 2rem;
        border-radius: 10px;
        width: 100%;
        margin-top: .5rem;
        transition: background .2s;
        cursor: pointer;
    }
    .btn-send:hover { background: #35b39a; }

    /* Info strip */
    .info-strip {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: .9rem;
        padding: .9rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .info-item:first-child { padding-top: 0; }
    .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #e8f8f5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-icon i { color: #4ac9b0; font-size: .9rem; }
    .info-label {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: .15rem;
    }
    .info-value {
        font-size: .88rem;
        color: #1a1a2e;
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .contact-card { padding: 1.75rem 1.25rem; }
    }
</style>

<section class="contact-page">
    <div class="container">

        <div class="page-header">
            <p class="eyebrow">Get in Touch</p>
            <h1>Contact Us</h1>
            <p>Have a question or concern? Send us a message and we'll get back to you as soon as possible.</p>
        </div>

        {{-- Map --}}
        <div id="map"></div>

        <div class="row g-4">
            {{-- Info sidebar --}}
            <div class="col-lg-4">
                <div class="info-strip">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="info-label">Address</div>
                            <div class="info-value">L & A Water Refilling Station</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="info-label">Hours</div>
                            <div class="info-value">Mon – Sat, 8:00 AM – 6:00 PM</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">h2whoa@gmail.com</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact form --}}
            <div class="col-lg-8">
                <div class="contact-card">
                    <h2>Send a Message</h2>

                    @if(session('success'))
                        <div style="background:#e8f8f5;border:1px solid #4ac9b0;color:#1a6e5c;padding:.85rem 1rem;border-radius:8px;font-size:.85rem;margin-bottom:1.25rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom" for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control-custom"
                                        placeholder="Your full name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div style="font-size:.75rem;color:#dc2626;margin-top:.3rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom" for="email">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control-custom"
                                        placeholder="you@example.com"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div style="font-size:.75rem;color:#dc2626;margin-top:.3rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="message">Message</label>
                            <textarea name="message" id="message"
                                class="form-control-custom"
                                placeholder="How can we help you?"
                                required>{{ old('message') }}</textarea>
                            @error('message')
                                <div style="font-size:.75rem;color:#dc2626;margin-top:.3rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn-send">Send Message</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script nonce="{{ csp_nonce() }}">
    function initMap() {
        const location = { lat: 6.41154, lng: 125.60835 };
        const map = new google.maps.Map(document.getElementById("map"), {
            center: location,
            zoom: 15,
            styles: [
                { featureType: "poi", stylers: [{ visibility: "off" }] }
            ]
        });
        new google.maps.Marker({
            position: location,
            map: map,
            title: "H2WHOA — L & A Water Refilling Station",
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(48, 48),
            },
        });
    }
</script>
<script nonce="{{ csp_nonce() }}"
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"
    async defer></script>
@endpush
@endsection

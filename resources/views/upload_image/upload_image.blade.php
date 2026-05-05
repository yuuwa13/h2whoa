@extends('layouts.admin')

@section('title', 'Upload Image')

@push('styles')
<style nonce="{{ csp_nonce() }}">
    /* Tab buttons */
    .img-tab-btn {
        background: transparent;
        border: 1.5px solid #e0e7ef;
        border-radius: 8px;
        padding: 7px 20px;
        font-size: 0.83rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all .2s;
    }
    .img-tab-btn.active,
    .img-tab-btn:hover {
        background: #4ac9b0;
        border-color: #4ac9b0;
        color: #fff;
    }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #c8d6e0;
        border-radius: 12px;
        padding: 32px 20px;
        text-align: center;
        background: #f8fafc;
        transition: border-color .2s, background .2s;
        cursor: pointer;
    }
    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #4ac9b0;
        background: #f0faf8;
    }
    .upload-zone .upload-icon {
        font-size: 2rem;
        color: #4ac9b0;
        margin-bottom: 10px;
    }
    .upload-zone p { font-size: 0.85rem; color: #64748b; margin: 0; }
    .upload-zone strong { color: #4ac9b0; }

    /* Image grid */
    .img-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }
    .img-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow .2s;
    }
    .img-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); }
    .img-card .img-thumb {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
        cursor: pointer;
    }
    .img-card .img-info {
        padding: 8px 10px;
        border-top: 1px solid #f0f4f8;
    }
    .img-card .img-name {
        font-size: 0.72rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 6px;
    }
    .btn-del {
        background: transparent;
        border: 1.5px solid #fca5a5;
        color: #dc2626;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        cursor: pointer;
        width: 100%;
        transition: all .2s;
    }
    .btn-del:hover { background: #fee2e2; }

    /* Empty state */
    .empty-img { text-align: center; padding: 40px 20px; color: #94a3b8; }
    .empty-img i { font-size: 2.5rem; margin-bottom: 10px; opacity: .4; }
    .empty-img p { font-size: 0.85rem; margin: 0; }

    /* Section label */
    .section-divider {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #94a3b8;
        margin: 0 0 4px;
    }

    #fileNameDisplay {
        font-size: 0.8rem;
        color: #4ac9b0;
        margin-top: 8px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="card shadow-sm border-0" style="border-radius:12px; overflow:hidden;">
    <div class="card-body p-4">

        {{-- Header + Tab toggle --}}
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <h5 class="fw-bold mb-0" style="color:#1e293b;">
                <i class="fas fa-images me-2" style="color:#4ac9b0;"></i>Image Manager
            </h5>
            <div class="d-flex gap-2">
                <button class="img-tab-btn active" id="tabUploaded">Uploaded Images</button>
                <button class="img-tab-btn" id="tabGcash">GCash Images</button>
            </div>
        </div>

        {{-- ── Uploaded Images Panel ── --}}
        <div id="panelUploaded">
            <p class="section-divider">Upload a New Image</p>
            <form action="{{ route('admin.upload-image.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="upload-zone mb-3" id="uploadZone">
                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <p><strong>Click to browse</strong> or drag & drop an image here</p>
                    <p class="mt-1" style="font-size:0.75rem;">JPEG, PNG, JPG, GIF — max 10MB</p>
                    <input type="file" id="imageInput" name="image" accept="image/*" required
                           style="position:absolute; opacity:0; width:0; height:0;">
                    <div id="fileNameDisplay"></div>
                </div>
                <button type="submit" style="background:linear-gradient(135deg,#4ac9b0,#35b39a); color:#fff; border:none; border-radius:10px; font-size:0.95rem; font-weight:700; padding:11px 32px; letter-spacing:.3px; box-shadow:0 4px 14px rgba(74,201,176,.4); cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fas fa-upload"></i> Upload Image
                </button>
            </form>

            <hr class="my-4" style="border-color:#f0f4f8;">

            <p class="section-divider">Gallery ({{ count($images) }} image{{ count($images) !== 1 ? 's' : '' }})</p>

            @if($images->isEmpty())
                <div class="empty-img">
                    <i class="fas fa-image"></i>
                    <p>No images uploaded yet.</p>
                </div>
            @else
                <div class="img-grid">
                    @foreach($images as $image)
                    <div class="img-card">
                        <a href="{{ $image['url'] }}" target="_blank">
                            <img src="{{ $image['url'] }}" class="img-thumb" alt="{{ $image['file_name'] }}">
                        </a>
                        <div class="img-info">
                            <div class="img-name" title="{{ $image['file_name'] }}">{{ $image['file_name'] }}</div>
                            <form class="delete-form" action="{{ route('admin.upload-image.delete', $image['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── GCash Images Panel ── --}}
        <div id="panelGcash" style="display:none;">
            <p class="section-divider">GCash Payment Screenshots ({{ count($gcashImages) }})</p>

            @if($gcashImages->isEmpty())
                <div class="empty-img">
                    <i class="fas fa-mobile-alt"></i>
                    <p>No GCash payment images yet.</p>
                </div>
            @else
                <div class="img-grid">
                    @foreach($gcashImages as $gcashImage)
                    <div class="img-card">
                        <a href="{{ asset('storage/' . $gcashImage->image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $gcashImage->image) }}" class="img-thumb" alt="GCash Image">
                        </a>
                        <div class="img-info">
                            <div class="img-name" title="{{ basename($gcashImage->image) }}">{{ basename($gcashImage->image) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function () {

    // ── Tab switching ──
    var tabUploaded  = document.getElementById('tabUploaded');
    var tabGcash     = document.getElementById('tabGcash');
    var panelUploaded = document.getElementById('panelUploaded');
    var panelGcash    = document.getElementById('panelGcash');

    tabUploaded.addEventListener('click', function () {
        panelUploaded.style.display = '';
        panelGcash.style.display   = 'none';
        tabUploaded.classList.add('active');
        tabGcash.classList.remove('active');
    });

    tabGcash.addEventListener('click', function () {
        panelGcash.style.display    = '';
        panelUploaded.style.display = 'none';
        tabGcash.classList.add('active');
        tabUploaded.classList.remove('active');
    });

    // ── Upload zone click → file input ──
    var zone      = document.getElementById('uploadZone');
    var fileInput = document.getElementById('imageInput');
    var fileLabel = document.getElementById('fileNameDisplay');

    zone.addEventListener('click', function () { fileInput.click(); });

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileLabel.textContent = '✓ ' + fileInput.files[0].name;
        }
    });

    // ── Drag & drop ──
    zone.addEventListener('dragover', function (e) { e.preventDefault(); zone.classList.add('dragover'); });
    zone.addEventListener('dragleave', function ()  { zone.classList.remove('dragover'); });
    zone.addEventListener('drop', function (e) {
        e.preventDefault();
        zone.classList.remove('dragover');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileLabel.textContent = '✓ ' + e.dataTransfer.files[0].name;
        }
    });

    // ── Delete confirmation ──
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete Image?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it',
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // ── Flash messages ──
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
    @elseif(session('error'))
        Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
    @endif
});
</script>
@endpush

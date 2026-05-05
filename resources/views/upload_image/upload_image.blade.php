<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
@extends('layouts.admin')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Upload Image</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_admin/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <div class="container mt-4">
                    <h3 class="text-dark mb-4">Upload Image</h3>

                    <!-- Selection Menu -->
                    <div class="mb-4">
                        <select id="imageCategory" class="form-select" onchange="toggleImageCategory()">
                            <option value="uploaded">Uploaded Images</option>
                            <option value="gcash">G-Cash Images</option>
                        </select>
                    </div>

                    <!-- Image Upload Form -->
                    <form action="{{ route('admin.upload-image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="form-label">Choose an image to upload</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-5">Upload</button>
                    </form>

                    <!-- Uploaded Images Section -->
                    <div id="uploadedImages" class="image-category">
                        <h4>Uploaded Images</h4>
                        <div class="row">
                            @forelse ($images as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <a href="{{ $image['url'] }}" target="_blank">
                                            <img src="{{ $image['url'] }}" class="card-img-top" alt="Uploaded Image">
                                        </a>
                                        <div class="card-body text-center">
                                            <p class="card-text">{{ $image['file_name'] }}</p>
                                            <form action="{{ route('admin.upload-image.delete', $image['id']) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No images uploaded yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- G-Cash Images Section -->
                    <div id="gcashImages" class="image-category" style="display: none;">
                        <h4>G-Cash Images</h4>
                        <div class="row">
                            @forelse ($gcashImages as $gcashImage)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <a href="{{ asset('storage/' . $gcashImage->image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $gcashImage->image) }}" class="card-img-top"
                                                alt="G-Cash Image">
                                        </a>
                                        <div class="card-body text-center">
                                            <p class="card-text">{{ $gcashImage->image }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No G-Cash images available yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <script nonce="{{ csp_nonce() }}">
                    function toggleImageCategory() {
                        const selectedCategory = document.getElementById('imageCategory').value;
                        document.getElementById('uploadedImages').style.display = selectedCategory === 'uploaded' ? 'block' : 'none';
                        document.getElementById('gcashImages').style.display = selectedCategory === 'gcash' ? 'block' : 'none';
                        document.querySelector('form[action="{{ route('admin.upload-image.store') }}"]').style.display = selectedCategory === 'uploaded' ? 'block' : 'none';
                    }
                </script>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"></div>
                </div>
            </footer>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/bs-init.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script nonce="{{ csp_nonce() }}"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script nonce="{{ csp_nonce() }}"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script nonce="{{ csp_nonce() }}"
        src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---1-Index-Table-with-Search--Sort-Filters.js') }}"></script>
    <script nonce="{{ csp_nonce() }}"
        src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---Material-UI-Actions.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>

    @if (session('success'))
        <script nonce="{{ csp_nonce() }}">
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @elseif (session('error'))
        <script nonce="{{ csp_nonce() }}">
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
</body>

</html>

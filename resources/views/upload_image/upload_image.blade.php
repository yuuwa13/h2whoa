<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark"
            style="background: rgba(255, 255, 255, 0.04);font-size: 22px;color: rgba(133,135,150,0.04);">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
                    href="{{ route('admin.stocks') }}">
                    <picture>
                        <img class="img-fluid" width="80" height="60" style="width: 85px;height: 87px;"
                            src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}">
                    </picture>
                    <div class="sidebar-brand-icon rotate-n-15"></div>
                    <div class="sidebar-brand-text mx-3"><span
                            style="color: var(--bs-primary-text-emphasis);">H2WHOA</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"
                            style="color: var(--bs-emphasis-color);"><i class="fas fa-tachometer-alt"
                                style="--bs-primary: rgb(33,33,33);--bs-primary-rgb: 33,33,33;color: var(--bs-accordion-active-color);"></i><span>Dashboard</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.stocks') }}"><i class="fas fa-user"
                                style="color: var(--bs-emphasis-color);"></i><span
                                style="color: var(--bs-secondary-text-emphasis);">Stocks</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}"
                            style="color: var(--bs-secondary-text-emphasis);"><i class="fas fa-table"
                                style="padding-left: -24px;color: var(--bs-accordion-active-color);"></i><span>Orders</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}"><i
                                class="fas fa-cash-register" style="color: var(--bs-accordion-active-color);"></i><span
                                style="color: var(--bs-secondary-text-emphasis);">Sales</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.history') }}"><i
                                class="fas fa-history" style="color: var(--bs-accordion-active-color);"></i><span
                                style="color: var(--bs-secondary-text-emphasis);">History</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.activity-log') }}"><i
                                class="fas fa-list" style="color: var(--bs-accordion-active-color);"></i><span
                                style="color: var(--bs-secondary-text-emphasis);">Activity Log</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.upload-image') }}"><i
                                class="fas fa-upload" style="color: var(--bs-accordion-active-color);"></i><span
                                style="color: var(--bs-secondary-text-emphasis);">Upload Image</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0"
                        id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop"
                            type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown"
                                        href="#"><i class="far fa-user"
                                            style="margin-right: 21px;font-size: 27px;"></i><span
                                            class="d-none d-lg-inline me-2 text-gray-600 small">Admin</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="#"><i
                                                class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity
                                            log</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.logout') }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i
                                                    class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
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
                        <div class="mb-3">
                            <label for="image" class="form-label">Choose an image to upload</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
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

                <script>
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
    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/bs-init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script
        src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---1-Index-Table-with-Search--Sort-Filters.js') }}"></script>
    <script
        src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---Material-UI-Actions.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @elseif (session('error'))
        <script>
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
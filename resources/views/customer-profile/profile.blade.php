@extends('layouts.app')
@section('title', 'My Profile')

@push('styles')
<style nonce="{{ csp_nonce() }}">
    .profile-section { padding: 36px 0 60px; }

    /* Profile header card */
    .profile-header-card {
        background: linear-gradient(135deg, #4ac9b0 0%, #38b89e 100%);
        border-radius: 14px;
        padding: 28px 28px 24px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }
    .avatar-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: rgba(255,255,255,0.25);
        border: 2px solid rgba(255,255,255,0.5);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .profile-header-card h4 { font-weight: 700; font-size: 1.1rem; margin: 0 0 4px; }
    .profile-header-card .meta { font-size: 0.8rem; opacity: 0.85; display: flex; flex-wrap: wrap; gap: 14px; margin-top: 6px; }
    .profile-header-card .meta span { display: flex; align-items: center; gap: 5px; }

    /* Content cards */
    .profile-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .profile-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #f0f4f8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .profile-card-header h6 {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #4ac9b0;
        margin: 0;
    }
    .profile-card-body { padding: 20px; }

    /* Form styling */
    .form-label { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px; }
    .form-control {
        border-radius: 8px;
        border: 1.5px solid #e0e7ef;
        font-size: 0.875rem;
        padding: 9px 12px;
        color: #1e293b;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus { border-color: #4ac9b0; box-shadow: 0 0 0 3px rgba(74,201,176,.15); }
    .form-control[readonly] { background: #f8fafc; color: #64748b; cursor: default; }

    /* Buttons */
    .btn-brand {
        background: #4ac9b0; color: #fff; border: none;
        border-radius: 8px; font-size: 0.82rem; font-weight: 600;
        padding: 8px 18px; transition: background .2s; cursor: pointer;
    }
    .btn-brand:hover { background: #38b89e; color: #fff; }
    .btn-brand:disabled { background: #a8dfd4; cursor: not-allowed; }

    .btn-outline-brand {
        background: transparent; color: #4ac9b0;
        border: 1.5px solid #4ac9b0; border-radius: 8px;
        font-size: 0.82rem; font-weight: 600; padding: 8px 18px;
        transition: all .2s; cursor: pointer;
    }
    .btn-outline-brand:hover { background: #4ac9b0; color: #fff; }

    .btn-ghost {
        background: transparent; color: #64748b;
        border: 1.5px solid #e0e7ef; border-radius: 8px;
        font-size: 0.82rem; font-weight: 600; padding: 8px 18px;
        transition: all .2s; cursor: pointer;
    }
    .btn-ghost:hover { border-color: #94a3b8; color: #374151; }

    .btn-danger-outline {
        background: transparent; color: #dc2626;
        border: 1.5px solid #fca5a5; border-radius: 8px;
        font-size: 0.82rem; font-weight: 600; padding: 8px 18px;
        transition: all .2s; cursor: pointer;
    }
    .btn-danger-outline:hover { background: #fef2f2; border-color: #dc2626; }

    /* Human checkbox area */
    .human-check { background: #f8fafc; border: 1px solid #e8edf2; border-radius: 8px; padding: 12px 14px; margin-bottom: 16px; }
    .form-check-input:checked { background-color: #4ac9b0; border-color: #4ac9b0; }

    /* Edit history table */
    .history-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .history-table th { background: #f8fafc; padding: 9px 14px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; }
    .history-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; color: #374151; }
    .history-table tr:last-child td { border-bottom: none; }
    .history-table .empty-row td { text-align: center; color: #94a3b8; padding: 24px; }

    /* Footer actions */
    .profile-footer { display: flex; gap: 10px; flex-wrap: wrap; padding-top: 4px; }

    /* Modal */
    .modal-content { border-radius: 12px; border: none; overflow: hidden; }
    .modal-header  { padding: 16px 20px; border-bottom: 1px solid #f0f4f8; }
    .modal-title   { font-weight: 700; font-size: 0.95rem; }
    .modal-body    { padding: 20px; font-size: 0.875rem; }
    .modal-footer  { padding: 14px 20px; border-top: 1px solid #f0f4f8; }

    .warning-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 12px 14px; font-size: 0.82rem; color: #92400e; margin-bottom: 16px; }
</style>
@endpush

@section('content')

    @if(session('status'))
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon:'success', title:'Profile Updated', text:'{{ session('status') }}', toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true });
            });
        </script>
    @endif

    <div class="profile-section">
        <div class="container" style="max-width: 700px;">

            {{-- Profile header --}}
            <div class="profile-header-card">
                <div class="avatar-circle">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                <div>
                    <h4>{{ $customer->name }}</h4>
                    <div class="meta">
                        <span><i class="fas fa-id-badge"></i> ID #{{ $customer->customer_id }}</span>
                        <span><i class="fas fa-calendar-alt"></i> Member since {{ $createdFormatted }}</span>
                    </div>
                </div>
            </div>

            {{-- Profile info / edit form --}}
            <div class="profile-card">
                <div class="profile-card-header">
                    <h6><i class="fas fa-user me-1"></i> Account Information</h6>
                    <button type="button" id="editProfileBtn" class="btn-outline-brand">
                        <i class="fas fa-pen me-1"></i> Edit
                    </button>
                </div>
                <div class="profile-card-body">
                    <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $customer->name) }}" readonly>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $customer->email) }}" readonly>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $customer->address) }}" readonly>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" maxlength="11"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $customer->phone) }}" readonly>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="password" class="form-label">New Password <small style="text-transform:none; letter-spacing:0;">(leave blank to keep)</small></label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" readonly>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" readonly>
                            </div>
                        </div>

                        {{-- Action area (hidden until Edit is clicked) --}}
                        <div id="actionArea" class="d-none mt-4">
                            <div class="human-check mb-3">
                                <div class="form-check mb-0">
                                    <input class="form-check-input @error('human') is-invalid @enderror"
                                        type="checkbox" id="human" name="human">
                                    <label class="form-check-label" for="human" style="font-size:0.85rem;">Are you human?</label>
                                    @error('human')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button id="saveBtn" type="submit" class="btn-brand" disabled>Save Changes</button>
                                <button id="cancelBtn" type="button" class="btn-ghost">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Edit History --}}
            <div class="profile-card">
                <div class="profile-card-header">
                    <h6><i class="fas fa-history me-1"></i> Edit History</h6>
                </div>
                <div class="profile-card-body" style="padding: 0;">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>When</th>
                                <th>Field</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($editLogs as $log)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($log->changed_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                                    <td>{{ ucfirst($log->field) }}</td>
                                    <td style="color:#94a3b8;">{{ $log->old_value }}</td>
                                    <td>{{ $log->new_value }}</td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="4">No edits yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Logout & Delete --}}
            <div class="profile-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
                <button type="button" class="btn-danger-outline" data-bs-toggle="modal" data-bs-target="#deleteModalStep1">
                    <i class="fas fa-trash-alt me-1"></i> Delete Account
                </button>
            </div>

        </div>
    </div>

    {{-- Delete Modal Step 1 --}}
    <div class="modal fade" id="deleteModalStep1" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST" action="{{ route('profile.destroy') }}">
                @csrf @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="warning-box">
                            <strong>Warning:</strong> This will <em>permanently</em> delete your account and all associated data.
                        </div>
                        <div class="mb-3">
                            <label for="del-password" class="form-label">Confirm Your Password</label>
                            <input type="password" name="password" id="del-password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input @error('confirm_delete') is-invalid @enderror"
                                type="checkbox" id="confirm-delete" name="confirm_delete">
                            <label class="form-check-label" for="confirm-delete" style="font-size:0.85rem;">
                                I understand this action <strong>cannot</strong> be undone.
                            </label>
                            @error('confirm_delete')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('human') is-invalid @enderror"
                                type="checkbox" id="confirm-human" name="human">
                            <label class="form-check-label" for="confirm-human" style="font-size:0.85rem;">Are you human?</label>
                            @error('human')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="toStep2" disabled style="border-radius:8px; font-size:0.82rem;">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal Step 2 --}}
    <div class="modal fade" id="deleteModalStep2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background:#dc2626; color:#fff; border-bottom:none;">
                    <h5 class="modal-title">Last Chance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:brightness(0) invert(1);"></button>
                </div>
                <div class="modal-body">
                    <p style="margin:0;">Are you absolutely sure you want to delete your account?<br><strong>This cannot be recovered.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-ghost" data-bs-target="#deleteModalStep1" data-bs-toggle="modal">Go Back</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete" style="border-radius:8px; font-size:0.82rem;">Yes, Delete My Account</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', () => {
        const editBtn  = document.getElementById('editProfileBtn');
        const action   = document.getElementById('actionArea');
        const inputs   = Array.from(document.querySelectorAll('#editProfileForm input'))
                            .filter(i => ['text','email','password'].includes(i.type));
        const humanChk = document.getElementById('human');
        const saveBtn  = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        editBtn.addEventListener('click', () => {
            inputs.forEach(i => i.removeAttribute('readonly'));
            action.classList.remove('d-none');
            editBtn.classList.add('d-none');

            const addressInput = document.getElementById('address');
            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                types: ['geocode'],
                componentRestrictions: { country: 'ph' },
            });
        });

        humanChk.addEventListener('change', () => {
            saveBtn.disabled = !humanChk.checked;
        });

        cancelBtn.addEventListener('click', () => window.location.reload());
    });
</script>

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', () => {
        const pass      = document.getElementById('del-password');
        const confirmCh = document.getElementById('confirm-delete');
        const humanCh   = document.getElementById('confirm-human');
        const nextBtn   = document.getElementById('toStep2');
        const step1     = new bootstrap.Modal(document.getElementById('deleteModalStep1'));
        const step2     = new bootstrap.Modal(document.getElementById('deleteModalStep2'));
        const confirm   = document.getElementById('confirmDelete');
        const form      = document.getElementById('deleteForm');

        function toggleNext() {
            nextBtn.disabled = !(pass.value.trim() && confirmCh.checked && humanCh.checked);
        }
        [pass, confirmCh, humanCh].forEach(el => el.addEventListener('input', toggleNext));

        nextBtn.addEventListener('click', () => { step1.hide(); step2.show(); });
        confirm.addEventListener('click', () => form.submit());
    });
</script>

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const addressInput = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(addressInput, {
            types: ['geocode'],
            componentRestrictions: { country: 'ph' },
        });
        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                alert('No details available for the selected location.');
            }
        });
    });
</script>
<script nonce="{{ csp_nonce() }}" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
@endpush

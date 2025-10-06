@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
  <div class="container my-5 px-3 px-sm-4 px-md-5" style="max-width: 100%; max-width: 700px;">
    <h2 class="mb-4">My Profile</h2>

    {{-- SweetAlert for Success Message --}}
    @if(session('status'))
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            icon: 'success',
            title: 'Profile Updated',
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

    {{-- Customer ID & Created Date --}}
    <dl class="row">
      <dt class="col-sm-3">Customer ID</dt>
      <dd class="col-sm-9">{{ $customer->customer_id }}</dd>

      <dt class="col-sm-3">Created On</dt>
      <dd class="col-sm-9">{{ $createdFormatted }}</dd>
    </dl>

    {{-- Editable form --}}
    <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
      @csrf @method('PUT')

      {{-- Edit Profile trigger --}}
      <button type="button" id="editProfileBtn" class="btn btn-secondary mb-4">Edit Profile</button>

      {{-- Name --}}
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
          value="{{ old('name', $customer->name) }}" readonly>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
          value="{{ old('email', $customer->email) }}" readonly>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Address --}}
      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror"
          value="{{ old('address', $customer->address) }}" readonly>
        @error('address')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      {{-- Phone --}}
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
          maxlength="11" value="{{ old('phone', $customer->phone) }}" readonly>
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-3">
        <label for="password" class="form-label">New Password <small>(leave blank to keep current)</small></label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
          readonly>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" readonly>
      </div>

      {{-- Action area: hidden until “Edit Profile” --}}
      <div id="actionArea" class="d-none mb-4">
        <div class="form-check mb-2">
          <input class="form-check-input @error('human') is-invalid @enderror" type="checkbox" id="human" name="human">
          <label class="form-check-label" for="human">Are you human?</label>
          @error('human')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <button id="saveBtn" type="submit" class="btn btn-primary me-2" disabled>Save Changes</button>
        <button id="cancelBtn" type="button" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
    {{-- Step 1: Password + confirm + human --}}
    <div class="modal fade" id="deleteModalStep1" tabindex="-1">
      <div class="modal-dialog">
        <form id="deleteForm" method="POST" action="{{ route('profile.destroy') }}">
          @csrf @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-danger">Delete Account</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p class="text-warning">
                <strong>Warning:</strong> This will <em>permanently</em> delete your account and all data.
              </p>

              {{-- Password --}}
              <div class="mb-3">
                <label for="del-password" class="form-label">Confirm Password</label>
                <input type="password" name="password" id="del-password"
                  class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Confirm delete --}}
              <div class="form-check mb-2">
                <input class="form-check-input @error('confirm_delete') is-invalid @enderror" type="checkbox"
                  id="confirm-delete" name="confirm_delete">
                <label class="form-check-label" for="confirm-delete">
                  I understand this action <strong>cannot</strong> be undone.
                </label>
                @error('confirm_delete')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Are you human? --}}
              <div class="form-check">
                <input class="form-check-input @error('human') is-invalid @enderror" type="checkbox" id="confirm-human"
                  name="human">
                <label class="form-check-label" for="confirm-human">Are you human?</label>
                @error('human')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger" id="toStep2" disabled>Next</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Step 2: Final confirmation --}}
    <div class="modal fade" id="deleteModalStep2" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Last Chance!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>
              Are you absolutely sure you want to delete your account?<br>
              <strong>This cannot be recovered.</strong>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-target="#deleteModalStep1" data-bs-toggle="modal">Go
              Back</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete My Account</button>
          </div>
        </div>
      </div>
    </div>

    {{-- Edit History --}}
    <h4 class="mt-5">Edit History</h4>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>When</th>
            <th>Field</th>
            <th>Old</th>
            <th>New</th>
          </tr>
        </thead>
        <tbody>
          @forelse($editLogs as $log)
            <tr>
              <td>{{ \Carbon\Carbon::parse($log->changed_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
              <td>{{ ucfirst($log->field) }}</td>
              <td>{{ $log->old_value }}</td>
              <td>{{ $log->new_value }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">No edits yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>


    {{-- Logout & Delete placeholders --}}
    <div class="mt-4 d-flex flex-column flex-md-row gap-2">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100 w-md-auto">Logout</button>
      </form>

      <button type="button" class="btn btn-outline-danger w-100 w-md-auto" data-bs-toggle="modal"
        data-bs-target="#deleteModalStep1">
        Delete Account
      </button>
    </div>

  </div>

  {{-- JS to enable Save only when form is dirty & human is checked --}}
  @push('scripts')
    <style>
      input,
      button,
      select,
      textarea {
        font-size: 1rem;
      }

      @media (max-width: 576px) {
        .form-label {
          font-size: 0.95rem;
        }

        .btn {
          font-size: 0.95rem;
          padding: 0.5rem 1rem;
        }
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const editBtn = document.getElementById('editProfileBtn');
        const action = document.getElementById('actionArea');
        const inputs = Array.from(document.querySelectorAll('#editProfileForm input'))
          // exclude hidden CSRF/_method fields
          .filter(i => ['text', 'email', 'password'].includes(i.type));
        const humanChk = document.getElementById('human');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        editBtn.addEventListener('click', () => {
          inputs.forEach(i => i.removeAttribute('readonly'));
          action.classList.remove('d-none');
          editBtn.classList.add('d-none');

          // Enable Google Places Autocomplete for the address field
          const addressInput = document.getElementById('address');
          const autocomplete = new google.maps.places.Autocomplete(addressInput, {
            types: ['geocode'],
            componentRestrictions: { country: 'ph' },
          });
        });

        // 2) Enable Save as soon as human is checked
        humanChk.addEventListener('change', () => {
          saveBtn.disabled = !humanChk.checked;
        });

        // 3) Cancel reloads to reset everything
        cancelBtn.addEventListener('click', () => window.location.reload());
      });
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const pass = document.getElementById('del-password');
        const confirmCh = document.getElementById('confirm-delete');
        const humanCh = document.getElementById('confirm-human');
        const nextBtn = document.getElementById('toStep2');
        const step1 = new bootstrap.Modal(document.getElementById('deleteModalStep1'));
        const step2 = new bootstrap.Modal(document.getElementById('deleteModalStep2'));
        const confirm = document.getElementById('confirmDelete');
        const form = document.getElementById('deleteForm');

        // Enable Next only if all three inputs are present/checked
        function toggleNext() {
          nextBtn.disabled = !(pass.value.trim()
            && confirmCh.checked
            && humanCh.checked);
        }
        [pass, confirmCh, humanCh].forEach(el =>
          el.addEventListener('input', toggleNext)
        );

        // Go to step2
        nextBtn.addEventListener('click', () => {
          step1.hide();
          step2.show();
        });

        // Final delete → submit the form
        confirm.addEventListener('click', () => form.submit());
      });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const addressInput = document.getElementById('address');

        // Initialize the Google Places Autocomplete
        const autocomplete = new google.maps.places.Autocomplete(addressInput, {
          types: ['geocode'], // Suggest addresses
          componentRestrictions: { country: 'ph' }, // Restrict to the Philippines
        });

        // Listen for the place_changed event
        autocomplete.addListener('place_changed', function () {
          const place = autocomplete.getPlace();

          // Check if the place has a geometry (valid location)
          if (!place.geometry) {
            alert('No details available for the selected location.');
            return;
          }

          // Optionally, log the selected place details
          console.log('Selected Place:', place);
        });
      });
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>


  @endpush

@endsection
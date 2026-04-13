@extends('layouts.master')

@section('title')
    User Management | Create User
@endsection

@section('contents')
    <div class="md:flex block items-center justify-between mb-6 mt-[2rem] page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Create User</h5>
            <nav>
                <ol class="flex items-center whitespace-nowrap min-w-0">
                    <li class="text-[12px]">
                        <a class="flex items-center text-textmuted hover:text-primary" href="{{ route('dashboard') }}">
                            Dashboard
                            <i
                                class="ti ti-chevrons-right flex-shrink-0 mx-3 overflow-visible text-textmuted rtl:rotate-180"></i>
                        </a>
                    </li>
                    <li class="text-[12px]">
                        <a class="flex items-center text-textmuted hover:text-primary" href="{{ route('users.index') }}">
                            Users Management
                            <i
                                class="ti ti-chevrons-right flex-shrink-0 mx-3 overflow-visible text-textmuted rtl:rotate-180"></i>
                        </a>
                    </li>
                    <li class="text-[12px]">
                        <span class="flex items-center text-primary">Create</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Start:: row-1 -->
    <div class="grid grid-cols-12 gap-6 text-defaultsize">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Create New User</div>
                </div>

                <div class="box-body">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="bd-example">
                            <div class="alert alert-danger !bg-danger/10 !text-danger border-0 py-3">
                                <div class="flex items-start">
                                    <i class="ri-error-warning-line me-2 text-lg"></i>
                                    <div>
                                        <strong class="block fw-semibold">Whoops! Something went wrong.</strong>
                                        <ul class="mb-0 mt-1 ps-4 list-disc">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="create-user-form" method="POST" action="{{ route('users.store') }}"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="fw-semibold mb-3 text-defaulttextcolor">
                                    <i class="ri-user-settings-line me-2"></i>Personal Information
                                </h6>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 sm:gap-6">

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="name" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-user-line"></i>
                                    </span>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Enter full name" required>
                                </div>
                                <div class="invalid-feedback">Please enter the user's name.</div>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-mail-line"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="name@example.com" required>
                                </div>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="birthdate" class="form-label">
                                    Birth Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-calendar-line"></i>
                                    </span>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate"
                                        value="{{ old('birthdate') }}">
                                </div>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="role" class="form-label">
                                    Account Role <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-shield-user-line"></i>
                                    </span>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="farm_worker" {{ old('role') == 'farm_worker' ? 'selected' : '' }}>Farm Worker</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Please select an account role.</div>
                            </div>


                        </div>

                        <!-- Profile Photo Section -->
                        <div class="row mb-4 mt-2">
                            <div class="col-md-12">
                                <div class="grid grid-cols-12 sm:gap-6">
                                    <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                        <label for="photo" class="form-label">
                                            Profile Photo
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text !bg-light !text-defaulttextcolor">
                                                <i class="ri-image-line"></i>
                                            </span>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                accept="image/jpeg,image/png,image/jpg,image/*"
                                                onchange="previewImage(event)">
                                        </div>
                                        <small class="text-textmuted">Allowed formats: JPG, PNG (Max: 2MB)</small>

                                        <div id="photo-preview" class="mt-3" style="display: none;">
                                            <p class="text-sm text-defaultsize mb-2 fw-semibold">Photo Preview:</p>
                                            <div class="position-relative d-inline-block">
                                                <img id="preview-img" src="" alt="Photo Preview"
                                                    class="w-24 h-24 object-cover rounded border border-defaultborder">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle"
                                                    onclick="removeImage()"
                                                    style="width: 20px; height: 20px; padding: 0; line-height: 1;">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Security Section -->
                        <div class="row mb-4 mt-5">
                            <div class="col-md-12">
                                <h6 class="fw-semibold mb-3 text-defaulttextcolor">
                                    <i class="ri-shield-key-line me-2"></i>Account Security
                                </h6>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 sm:gap-6">

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="password" class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-lock-line"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password" required>
                                    <button class="btn btn-light !bg-light" type="button"
                                        onclick="togglePassword('password', 'toggle-password-icon-1')">
                                        <i class="ri-eye-off-line" id="toggle-password-icon-1"></i>
                                    </button>
                                </div>
                                <small class="text-textmuted">Minimum 8 characters</small>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text !bg-light !text-defaulttextcolor">
                                        <i class="ri-lock-line"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm password" required>
                                    <button class="btn btn-light !bg-light" type="button"
                                        onclick="togglePassword('password_confirmation', 'toggle-password-icon-2')">
                                        <i class="ri-eye-off-line" id="toggle-password-icon-2"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-defaultborder">
                            <a href="{{ route('users.index') }}" class="ti-btn ti-btn-light !font-medium">
                                <i class="ri-arrow-left-line me-1"></i> Cancel
                            </a>
                            <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">
                                <i class="ri-check-line me-1"></i> Save Changes
                            </button>
                        </div>

                    </form>

                </div>

                <div class="box-footer hidden border-t-0"></div>
            </div>
        </div>
    </div>
    <!-- End:: row-1 -->
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert2 confirm before save (Valex style-2)
        document.getElementById('save-changes-btn').addEventListener('click', function() {
            const form = document.getElementById('create-user-form');
            const swalWithButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'ti-btn bg-primary text-white ms-2',
                    cancelButton: 'ti-btn bg-danger text-white'
                },
                buttonsStyling: false
            });
            swalWithButtons.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to update this user\'s information?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithButtons.fire('Cancelled', 'No changes were saved.', 'error');
                }
            });
        });
        // 1. Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        }

        // 2. Image Preview
        function previewImage(event) {
            const file = event.target.files[0];
            const previewDiv = document.getElementById('photo-preview');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Error', 'File size must be less than 2MB', 'error');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.style.display = 'none';
            }
        }

        // 3. Remove Image
        function removeImage() {
            const fileInput = document.getElementById('photo');
            const previewDiv = document.getElementById('photo-preview');
            const previewImg = document.getElementById('preview-img');

            fileInput.value = '';
            previewImg.src = '';
            previewDiv.style.display = 'none';
        }

        // 4. SweetAlert2 & Form Submission
        document.getElementById('create-user-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;

            // Check HTML5 Validation
            if (!form.checkValidity()) {
                form.classList.add('was-validated');

                // Optional: Scroll to the first error
                const firstError = form.querySelector(':invalid');
                if (firstError) firstError.focus();
                return;
            }

            const swalWithButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'ti-btn bg-primary text-white ms-2',
                    cancelButton: 'ti-btn bg-danger text-white'
                },
                buttonsStyling: false
            });

            swalWithButtons.fire({
                title: 'Create New User?',
                text: 'Are you sure you want to save this new user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // This programmatically submits the form
                }
            });
        });
    </script>
@endsection

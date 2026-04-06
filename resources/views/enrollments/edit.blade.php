@extends('layouts.master')

@section('title')
    Enrollment Management | Edit Enrollment
@endsection

@section('contents')
    <div class="md:flex block items-center justify-between mb-6 mt-[2rem] page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Edit Enrollment</h5>
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
                        <a class="flex items-center text-textmuted hover:text-primary" href="{{ route('enrollments.index') }}">
                            Enrollment Management
                            <i
                                class="ti ti-chevrons-right flex-shrink-0 mx-3 overflow-visible text-textmuted rtl:rotate-180"></i>
                        </a>
                    </li>
                    <li class="text-[12px]">
                        <span class="flex items-center text-primary">Edit</span>
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
                    <div class="box-title">Edit Enrollment for: {{ $enrollment->user->name }}</div>
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

                    <form id="edit-enrollment-form" method="POST" action="{{ route('enrollments.update', $enrollment->id) }}"
                         class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Enrollment Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="fw-semibold mb-3 text-defaulttextcolor">
                                    <i class="ri-bookmark-line me-2"></i>Enrollment Information
                                </h6>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 sm:gap-6">

                            <!-- User Dropdown (Read-Only effectively, or allowing changes. We let them change it as requested) -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="user_id" class="form-label">
                                    Student/User <span class="text-danger">*</span>
                                </label>
                                <select class="form-select text-defaultsize" id="user_id" name="user_id" required>
                                    <option value="" disabled>Select a User...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $enrollment->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a user to enroll.</div>
                            </div>

                            <!-- Subject Dropdown -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="subject_id" class="form-label">
                                    Subject <span class="text-danger">*</span>
                                </label>
                                <select class="form-select text-defaultsize" id="subject_id" name="subject_id" required>
                                    <option value="" disabled>Select a Subject...</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $enrollment->subject_id) == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }} [{{ $subject->code }}]
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a subject.</div>
                            </div>

                            <!-- Academic Year -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="school_year" class="form-label">
                                    School Year
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="school_year" name="school_year"
                                        value="{{ old('school_year', $enrollment->school_year) }}" placeholder="e.g., 2024-2025">
                                </div>
                            </div>

                            <!-- Semester -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="semester" class="form-label">
                                    Semester
                                </label>
                                <select class="form-select text-defaultsize" id="semester" name="semester">
                                    <option value="" disabled>Select Semester...</option>
                                    <option value="1st Semester" {{ old('semester', $enrollment->semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd Semester" {{ old('semester', $enrollment->semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="Summer" {{ old('semester', $enrollment->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="enrollment_status" class="form-label">
                                    Enrollment Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select text-defaultsize" id="enrollment_status" name="enrollment_status" required>
                                    <option value="enrolled" {{ old('enrollment_status', $enrollment->enrollment_status) == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                    <option value="completed" {{ old('enrollment_status', $enrollment->enrollment_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="dropped" {{ old('enrollment_status', $enrollment->enrollment_status) == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                </select>
                                <div class="invalid-feedback">Please select a valid enrollment status.</div>
                            </div>

                            <!-- Date Enrolled -->
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="date_enrolled" class="form-label">
                                    Date Enrolled <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="date_enrolled" name="date_enrolled"
                                        value="{{ old('date_enrolled', $enrollment->date_enrolled ? \Carbon\Carbon::parse($enrollment->date_enrolled)->format('Y-m-d') : '') }}" required>
                                </div>
                                <div class="invalid-feedback">Please select a valid enrollment date.</div>
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-defaultborder">
                            <a href="{{ route('enrollments.index') }}" class="ti-btn ti-btn-light !font-medium">
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
        // SweetAlert2 confirm before save
        document.getElementById('edit-enrollment-form').addEventListener('submit', function(e) {
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
                title: 'Save Changes?',
                text: 'Are you sure you want to save modifications to this enrollment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // This programmatically submits the form
                }
            });
        });
    </script>
@endsection

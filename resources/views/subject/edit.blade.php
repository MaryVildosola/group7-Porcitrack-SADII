@extends('layouts.master')

@section('title')
    Subject Management | Edit Subject
@endsection

@section('contents')
    <div class="md:flex block items-center justify-between mb-6 mt-[2rem] page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Edit Subject</h5>
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
                        <a class="flex items-center text-textmuted hover:text-primary" href="{{ route('subject.index') }}">
                            Subject Management
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
                    <div class="box-title">Edit Subject: {{ $subject->name }}</div>
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

                    <form id="edit-subject-form" method="POST" action="{{ route('subject.update', $subject->id) }}"
                         class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Subject Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="fw-semibold mb-3 text-defaulttextcolor">
                                    <i class="ri-book-read-line me-2"></i>Subject Information
                                </h6>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 sm:gap-6">

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="curriculum_name" class="form-label">
                                    Curriculum Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="curriculum_name" name="curriculum_name"
                                        value="{{ old('curriculum_name', $subject->curriculum_name) }}" placeholder="Enter curriculum name (e.g., K-12, BEC)" required>
                                </div>
                                <div class="invalid-feedback">Please enter the curriculum name.</div>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="name" class="form-label">
                                    Subject Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $subject->name) }}" placeholder="Enter subject name" required>
                                </div>
                                <div class="invalid-feedback">Please enter the subject name.</div>
                            </div>

                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="code" class="form-label">
                                    Subject Code <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ old('code', $subject->code) }}" placeholder="Enter unique code" required>
                                </div>
                                <div class="invalid-feedback">Please enter a unique subject code.</div>
                            </div>
                            
                            <div class="xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 mb-4">
                                <label for="is_active" class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <!-- Hidden field to always send 0 if unchecked -->
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $subject->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="xl:col-span-12 col-span-12 mb-4">
                                <label for="description" class="form-label">
                                    Description
                                </label>
                                <div class="input-group">
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Optional detailed description of the subject">{{ old('description', $subject->description) }}</textarea>
                                </div>
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-defaultborder">
                            <a href="{{ route('subject.index') }}" class="ti-btn ti-btn-light !font-medium">
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
        document.getElementById('edit-subject-form').addEventListener('submit', function(e) {
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
                text: 'Are you sure you want to update this subject\'s information?',
                icon: 'warning',
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

@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">Profile Settings</h1>
            <p class="text-white/60 mt-2">Manage your personal information and account security</p>
        </div>

        <form action="{{ route('worker.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Success/Alert Messages --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-500/20 border border-green-500/30 rounded-2xl text-green-300 text-sm flex items-center gap-3">
                    <i class='bx bx-check-circle text-xl'></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Profile Photo -->
                <div class="lg:col-span-1 text-center">
                    <div class="glass-panel p-8 rounded-3xl shadow-xl flex flex-col items-center">
                        <div class="relative group cursor-pointer">
                            <div class="w-40 h-40 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white/20 shadow-2xl relative bg-white/5">
                                <img id="profilePreview" 
                                     src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=65a767&color=fff&size=200' }}" 
                                     alt="Profile Photo" 
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <i class='bx bx-camera text-4xl text-white'></i>
                                </div>
                            </div>
                            <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('photoInput').click()" 
                                    class="absolute bottom-2 right-2 w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition active:scale-90 border-4 border-[#0f2818]">
                                <i class='bx bx-edit-alt text-xl'></i>
                            </button>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-white">{{ $user->name }}</h3>
                        <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Farm Worker</p>
                        
                        <div class="mt-8 w-full pt-8 border-t border-white/10 text-left space-y-4">
                            <div class="flex items-center gap-3 text-white/60">
                                <i class='bx bx-calendar text-lg'></i>
                                <span class="text-sm">Joined {{ $user->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/60">
                                <i class='bx bx-shield-check text-lg'></i>
                                <span class="text-sm text-green-400">Account Verified</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Form Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Basic Info -->
                    <div class="glass-panel p-6 md:p-8 rounded-3xl shadow-xl">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-user text-green-400'></i> Personal Details
                        </h2>
                        
                        <div class="space-y-5">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-semibold text-white/50 uppercase tracking-widest mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition">
                                @error('name') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email (Locked) -->
                            <div>
                                <label class="block text-xs font-semibold text-white/50 uppercase tracking-widest mb-2">Email Address</label>
                                <div class="flex gap-2">
                                    <input type="email" value="{{ $user->email }}" readonly
                                           class="flex-1 bg-white/5 border border-white/5 rounded-xl px-4 py-3 text-white/40 cursor-not-allowed italic">
                                    <button type="button" onclick="requestAdmin('email')"
                                            class="px-4 bg-white/10 text-white/60 border border-white/10 rounded-xl hover:bg-white/20 transition text-xs font-medium">
                                        Request Change
                                    </button>
                                </div>
                                <p class="text-[10px] text-white/30 mt-1 italic">* Requires administrator approval for security</p>
                            </div>

                            <!-- Phone (Locked) -->
                            <div>
                                <label class="block text-xs font-semibold text-white/50 uppercase tracking-widest mb-2">Phone Number</label>
                                <div class="flex gap-2">
                                    <input type="text" value="{{ $user->phone ?? 'Not set' }}" readonly
                                           class="flex-1 bg-white/5 border border-white/5 rounded-xl px-4 py-3 text-white/40 cursor-not-allowed italic">
                                    <button type="button" onclick="requestAdmin('phone')"
                                            class="px-4 bg-white/10 text-white/60 border border-white/10 rounded-xl hover:bg-white/20 transition text-xs font-medium">
                                        Request Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security / Password -->
                    <div class="glass-panel p-6 md:p-8 rounded-3xl shadow-xl border-l-4 border-l-amber-500/30">
                        <h2 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                            <i class='bx bx-lock-alt text-amber-400'></i> Update Password
                        </h2>
                        <p class="text-white/40 text-xs mb-6">Leave blank to keep your current password</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-white/50 uppercase tracking-widest mb-2">New Password</label>
                                <input type="password" name="password" placeholder="••••••••"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-500/50 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-white/50 uppercase tracking-widest mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-500/50 transition">
                            </div>
                        </div>
                        @error('password') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Action Bar -->
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('worker.dashboard') }}" class="text-white/60 hover:text-white transition font-medium text-sm">Cancel</a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-bold hover:shadow-[0_0_20px_rgba(34,197,94,0.4)] transition active:scale-95">
                            Save Changes
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 for Change Requests -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Image Preview Logic
        const photoInput = document.getElementById('photoInput');
        const profilePreview = document.getElementById('profilePreview');

        photoInput.onchange = evt => {
            const [file] = photoInput.files;
            if (file) {
                profilePreview.src = URL.createObjectURL(file);
            }
        }

        // Admin Request Mockup
        function requestAdmin(field) {
            Swal.fire({
                title: 'Request ' + field.charAt(0).toUpperCase() + field.slice(1) + ' Change',
                text: 'Please enter the new ' + field + ' you would like to use. This request will be sent to the administrator for verification.',
                input: 'text',
                inputPlaceholder: 'Enter new ' + field,
                showCancelButton: true,
                confirmButtonText: 'Submit Request',
                confirmButtonColor: '#22c55e',
                background: '#1a3a1a',
                color: '#ffffff',
                customClass: {
                    input: 'bg-white/5 border-white/10 text-white border rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Swal.fire({
                        title: 'Request Sent!',
                        text: 'Your request to change ' + field + ' has been submitted. You will be notified once the admin approves it.',
                        icon: 'success',
                        background: '#1a3a1a',
                        color: '#ffffff',
                        confirmButtonColor: '#22c55e'
                    });
                }
            });
        }
    </script>

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
@endsection

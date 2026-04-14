<x-guest-layout>
    <div class="auth-container">
        <!-- Sign Up Form Card (left side) -->
        <div class="form-card">
            <h2>Sign up</h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="User name"
                        required autofocus autocomplete="name">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 12c2.7 0 4-1.34 4-4s-1.3-4-4-4-4 1.34-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </span>
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        required autocomplete="username">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                    </span>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Profile Photo -->
                <div class="input-group">
                    <input id="photo" type="file" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('photo-label').innerText = this.files[0].name">
                    <div onclick="document.getElementById('photo').click()" class="cursor-pointer bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white/50 text-sm flex items-center gap-2 hover:bg-white/10 transition">
                        <i class='bx bx-image-add text-lg'></i>
                        <span id="photo-label">Upload Profile Photo</span>
                    </div>
                    @error('photo')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role -->
                <div class="input-group">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </span>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="farm_worker" {{ old('role') == 'farm_worker' ? 'selected' : '' }}>Farm Worker
                        </option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <input id="password" type="password" name="password" placeholder="Password" required
                        autocomplete="new-password">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                        </svg>
                    </span>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password (hidden but included for validation) -->
                <input type="hidden" name="password_confirmation" id="password_confirmation">
                <script>
                    document.getElementById('password').addEventListener('input', function() {
                        document.getElementById('password_confirmation').value = this.value;
                    });
                </script>

                <button type="submit" class="btn-login">Login</button>

                <div class="form-links center">
                    <a href="{{ route('login') }}">Already have an account?</a>
                </div>
            </form>
        </div>

        <!-- Logo Card (right side) -->
        <div class="logo-card">
            <img src="{{ asset('assets/images/pig-logo.png') }}" alt="PorciTrack Logo">
        </div>
    </div>
</x-guest-layout>

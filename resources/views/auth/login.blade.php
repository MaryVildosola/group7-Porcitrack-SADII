<x-guest-layout>
    <div class="auth-container">
        <!-- Logo Card -->
        <div class="logo-card">
            <img src="{{ asset('assets/images/pig-logo.png') }}" alt="PorciTrack Logo">
        </div>

        <!-- Login Form Card -->
        <div class="form-card">
            <h2>Login</h2>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </span>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                    >
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                    </span>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="form-links">
                    <a href="{{ route('register') }}">Create an account</a>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forget password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

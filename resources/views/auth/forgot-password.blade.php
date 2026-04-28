<x-guest-layout>
    <div class="auth-container">
        <div class="logo-card">
            <img src="{{ asset('assets/images/pig-logo.png') }}" alt="Logo">
        </div>

        <div class="form-card">
            <h2>Forgot Password</h2>
            <p class="register-subtitle">Enter your email to receive a reset link</p>

            <div class="mb-4 text-sm" style="color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="input-group">
                    <label class="field-label">Email Address</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit" class="btn-login">
                    {{ __('Email Reset Link') }}
                </button>

                <div class="form-links" style="justify-content: center;">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

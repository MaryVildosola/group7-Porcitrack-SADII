<x-guest-layout>

<style>
    /* Override guest layout card width for register */
    .auth-container { max-width: 980px !important; gap: 40px !important; }

    .form-card.register-card {
        max-width: 440px !important;
        padding: 40px 40px 36px !important;
    }

    .form-card.register-card h2 {
        font-size: 1.55rem;
        margin-bottom: 6px;
    }

    .register-subtitle {
        text-align: center;
        color: rgba(255,255,255,0.45);
        font-size: 0.8rem;
        margin-bottom: 28px;
        letter-spacing: 0.01em;
    }

    /* Field label */
    .field-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: rgba(255,255,255,0.45);
        margin-bottom: 7px;
    }

    /* Styled select to match inputs */
    .input-group select {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1.5px solid rgba(255,255,255,0.5);
        color: rgba(255,255,255,0.9);
        font-size: 0.9rem;
        padding: 8px 36px 8px 4px;
        outline: none;
        transition: border-color 0.2s;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .input-group select:focus { border-bottom-color: #66bb6a; }

    .input-group select option {
        background: #1a3a1a;
        color: #fff;
    }

    /* Two-column row for role + photo */
    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 18px;
    }

    .field-row .input-group { margin-bottom: 0; }

    /* File upload button */
    .file-upload-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        background: rgba(255,255,255,0.06);
        border: 1.5px dashed rgba(255,255,255,0.3);
        border-radius: 10px;
        padding: 9px 12px;
        color: rgba(255,255,255,0.55);
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }

    .file-upload-btn:hover {
        border-color: #66bb6a;
        color: #a5d6a7;
        background: rgba(102,187,106,0.07);
    }

    .file-upload-btn svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
        flex-shrink: 0;
    }

    .file-name-label {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    /* Avatar preview */
    .avatar-preview {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #66bb6a;
        display: none;
        flex-shrink: 0;
    }

    /* Password strength bar */
    .strength-bar-wrap {
        height: 3px;
        background: rgba(255,255,255,0.1);
        border-radius: 99px;
        margin-top: 6px;
        overflow: hidden;
    }

    .strength-bar {
        height: 100%;
        width: 0%;
        border-radius: 99px;
        transition: width 0.3s, background 0.3s;
    }

    .strength-label {
        font-size: 0.68rem;
        color: rgba(255,255,255,0.35);
        margin-top: 3px;
        min-height: 14px;
        transition: color 0.2s;
    }

    /* Divider */
    .form-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.1);
        margin: 20px 0;
    }

    .btn-register {
        width: 100%;
        padding: 12px;
        margin-top: 4px;
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        color: #fff;
        font-size: 0.95rem;
        font-weight: 700;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 15px rgba(46,125,50,0.5);
        letter-spacing: 0.03em;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #388e3c, #2e7d32);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(46,125,50,0.6);
    }

    .btn-register:active { transform: scale(0.98); }
</style>

<div class="auth-container">
    {{-- Logo Card --}}
    <div class="logo-card">
        <img src="{{ asset('assets/images/pig-logo.png') }}" alt="PorciTrack Logo">
    </div>

    {{-- Register Form Card --}}
    <div class="form-card register-card">
        <h2>Create Account</h2>
        <p class="register-subtitle">Join PorciTrack — Farm Management System</p>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
            @csrf

            {{-- Name --}}
            <div class="input-group">
                <label class="field-label" for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    placeholder="e.g. Juan dela Cruz" required autofocus autocomplete="name">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.7 0 4-1.34 4-4s-1.3-4-4-4-4 1.34-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </span>
                @error('name')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="input-group">
                <label class="field-label" for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="you@example.com" required autocomplete="username">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </span>
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Role + Photo side by side --}}
            <div class="field-row">
                {{-- Role --}}
                <div class="input-group">
                    <label class="field-label" for="role">Role</label>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                    </span>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>Select…</option>
                        <option value="farm_worker" {{ old('role') == 'farm_worker' ? 'selected' : '' }}>Farm Worker</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Profile Photo --}}
                <div class="input-group">
                    <label class="field-label">Profile Photo</label>
                    <input id="photo" type="file" name="photo" accept="image/*" class="hidden"
                        onchange="handlePhotoChange(this)">
                    <button type="button" class="file-upload-btn" onclick="document.getElementById('photo').click()">
                        <img id="avatarPreview" class="avatar-preview" src="" alt="">
                        <svg id="uploadIcon" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        <span class="file-name-label" id="photo-label">Upload Photo</span>
                    </button>
                    @error('photo')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="form-divider">

            {{-- Password --}}
            <div class="input-group">
                <label class="field-label" for="password">Password</label>
                <input id="password" type="password" name="password"
                    placeholder="Min. 8 characters" required autocomplete="new-password"
                    oninput="checkStrength(this.value)">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                </span>
                <div class="strength-bar-wrap"><div class="strength-bar" id="strengthBar"></div></div>
                <div class="strength-label" id="strengthLabel"></div>
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="input-group">
                <label class="field-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Re-enter password" required autocomplete="new-password"
                    oninput="checkMatch()">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </span>
                <div class="strength-label" id="matchLabel"></div>
                @error('password_confirmation')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-register">Create Account</button>

            <div class="form-links center" style="margin-top:18px;">
                <a href="{{ route('login') }}">Already have an account? Sign in</a>
            </div>
        </form>
    </div>
</div>

<script>
function handlePhotoChange(input) {
    const label = document.getElementById('photo-label');
    const preview = document.getElementById('avatarPreview');
    const icon = document.getElementById('uploadIcon');
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function checkStrength(val) {
    const bar = document.getElementById('strengthBar');
    const lbl = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const configs = [
        { width: '0%',   color: 'transparent', text: '' },
        { width: '25%',  color: '#ef5350',      text: 'Weak' },
        { width: '50%',  color: '#ffa726',      text: 'Fair' },
        { width: '75%',  color: '#66bb6a',      text: 'Good' },
        { width: '100%', color: '#26a69a',      text: 'Strong' },
    ];
    const c = configs[score];
    bar.style.width  = c.width;
    bar.style.background = c.color;
    lbl.textContent  = c.text;
    lbl.style.color  = c.color;
}

function checkMatch() {
    const pw  = document.getElementById('password').value;
    const pw2 = document.getElementById('password_confirmation').value;
    const lbl = document.getElementById('matchLabel');
    if (!pw2) { lbl.textContent = ''; return; }
    if (pw === pw2) {
        lbl.textContent = '✓ Passwords match';
        lbl.style.color = '#66bb6a';
    } else {
        lbl.textContent = '✗ Passwords do not match';
        lbl.style.color = '#ef5350';
    }
}
</script>
</x-guest-layout>

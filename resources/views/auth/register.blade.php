<x-guest-layout>

<style>
/* ─── Register-specific styles ─── */
.reg-heading {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 4px;
    letter-spacing: -.4px;
    transition: color .3s;
}
.reg-sub {
    font-size: 13px;
    color: var(--text-sub);
    margin: 0 0 24px;
    transition: color .3s;
}

/* ─── Notice banner ─── */
.notice-banner {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: var(--notice-bg);
    border: 1px solid var(--notice-b);
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 20px;
    transition: background .3s, border-color .3s;
}
.notice-banner svg { color: var(--notice-ic); flex-shrink: 0; margin-top: 1px; transition: color .3s; }
.notice-banner-title { font-size: 12px; font-weight: 700; color: var(--notice-t); margin-bottom: 2px; transition: color .3s; }
.notice-banner-text  { font-size: 12px; color: var(--notice-t); opacity: .85; line-height: 1.5; transition: color .3s; }

/* ─── Theme badge ─── */
.theme-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--badge-bg);
    border: 1px solid var(--badge-b);
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 20px;
    transition: background .3s, border-color .3s;
}
.theme-badge-icon { color: var(--primary); flex-shrink: 0; transition: color .3s; }
.theme-badge-label { font-size: 11px; color: var(--badge-t); font-weight: 500; margin-bottom: 1px; transition: color .3s; }
.theme-badge-value { font-size: 13px; font-weight: 700; color: var(--badge-t); transition: color .3s; }

/* ─── Form field ─── */
.field { margin-bottom: 18px; }
.field:last-of-type { margin-bottom: 0; }
.field-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--label);
    margin-bottom: 7px;
    transition: color .3s;
}
.field-input-wrap { position: relative; }
.field-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px; height: 16px;
    color: var(--text-mute);
    pointer-events: none;
    transition: color .3s;
    flex-shrink: 0;
}
.field-input {
    width: 100%;
    padding: 11px 14px 11px 40px;
    font-size: 14px;
    font-family: inherit;
    color: var(--text);
    background: var(--input-bg);
    border: 1.5px solid var(--input-b);
    border-radius: 12px;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .3s, color .3s;
    -webkit-appearance: none;
}
.field-input::placeholder { color: var(--text-mute); }
.field-input:focus {
    border-color: var(--input-b-f);
    box-shadow: 0 0 0 3px var(--input-ring);
}
.field-input.has-error {
    border-color: var(--error);
    box-shadow: 0 0 0 3px rgba(239,68,68,.12);
}
.field-error {
    font-size: 12px;
    color: var(--error);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.field-error svg { flex-shrink: 0; }

/* ─── Password toggle ─── */
.pw-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 32px; height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    cursor: pointer;
    color: var(--text-mute);
    border-radius: 8px;
    transition: color .2s, background .2s;
    padding: 0;
}
.pw-toggle:hover { color: var(--text-sub); background: var(--input-b); }
.pw-toggle svg { width: 16px; height: 16px; }

/* ─── Divider ─── */
.divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
}
.divider-line { flex: 1; height: 1px; background: var(--input-b); transition: background .3s; }
.divider-text { font-size: 12px; color: var(--text-mute); white-space: nowrap; transition: color .3s; }

/* ─── Submit button ─── */
.btn-submit {
    width: 100%;
    padding: 13px;
    font-size: 15px;
    font-weight: 700;
    font-family: inherit;
    color: var(--primary-t);
    background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(99,102,241,.30);
    transition: opacity .2s, transform .15s, box-shadow .2s;
    margin-top: 24px;
    letter-spacing: .1px;
    position: relative;
    overflow: hidden;
}
.btn-submit:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.38); }
.btn-submit:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(99,102,241,.25); }
.btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.btn-submit-spinner {
    display: none;
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ─── Login link row ─── */
.login-row {
    margin-top: 20px;
    text-align: center;
    font-size: 13px;
    color: var(--text-sub);
    transition: color .3s;
}
.login-row a {
    color: var(--link);
    font-weight: 600;
    text-decoration: none;
    margin-left: 4px;
    transition: color .2s;
}
.login-row a:hover { color: var(--link-h); text-decoration: underline; }
</style>

{{-- ── Heading ── --}}
<p class="reg-heading">Buat Akun</p>
<p class="reg-sub">Daftar untuk mulai membuat undangan digital</p>

{{-- ── Approval notice ── --}}
<div class="notice-banner">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
    </svg>
    <div>
        <p class="notice-banner-title">Perlu Persetujuan Admin</p>
        <p class="notice-banner-text">Akun Anda akan <strong>direview</strong> sebelum bisa digunakan. Biasanya selesai dalam 1×24 jam.</p>
    </div>
</div>

{{-- ── Theme badge ── --}}
@if(request('theme'))
<div class="theme-badge">
    <svg class="theme-badge-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/>
    </svg>
    <div>
        <p class="theme-badge-label">Tema yang dipilih</p>
        <p class="theme-badge-value">{{ request('theme') }}</p>
    </div>
</div>
@endif

{{-- ── Form ── --}}
<form method="POST" action="{{ route('register') }}" id="reg-form" onsubmit="handleSubmit(this)">
    @csrf
    <input type="hidden" name="selected_theme_slug" value="{{ request('theme') }}">

    {{-- Name --}}
    <div class="field">
        <label class="field-label" for="name">Nama Lengkap</label>
        <div class="field-input-wrap">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
            </svg>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   autocomplete="name"
                   placeholder="cth. Budi Santoso"
                   class="field-input {{ $errors->has('name') ? 'has-error' : '' }}">
        </div>
        @error('name')
        <p class="field-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
        @enderror
    </div>

    {{-- Email --}}
    <div class="field">
        <label class="field-label" for="email">Email</label>
        <div class="field-input-wrap">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
            </svg>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
                   placeholder="cth. budi@email.com"
                   class="field-input {{ $errors->has('email') ? 'has-error' : '' }}">
        </div>
        @error('email')
        <p class="field-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
        @enderror
    </div>

    {{-- Password --}}
    <div class="field">
        <label class="field-label" for="password">Password</label>
        <div class="field-input-wrap">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
            </svg>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
                   class="field-input {{ $errors->has('password') ? 'has-error' : '' }}"
                   style="padding-right: 44px;">
            <button type="button" class="pw-toggle" onclick="togglePw('password',this)" tabindex="-1" aria-label="Tampilkan password">
                <svg id="eye-password" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </button>
        </div>
        @error('password')
        <p class="field-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="field">
        <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="field-input-wrap">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
            </svg>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   placeholder="Ulangi password"
                   class="field-input"
                   style="padding-right: 44px;">
            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation',this)" tabindex="-1" aria-label="Tampilkan konfirmasi password">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </button>
        </div>
        @error('password_confirmation')
        <p class="field-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
        @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-submit" id="btn-submit">
        <span id="btn-text">Buat Akun</span>
        <div class="btn-submit-spinner" id="btn-spinner"></div>
    </button>
</form>

{{-- Login link --}}
<p class="login-row">
    Sudah punya akun?
    <a href="{{ route('login') }}">Masuk sekarang</a>
</p>

<script>
function togglePw(id, btn) {
    var input = document.getElementById(id);
    var isHide = input.type === 'password';
    input.type = isHide ? 'text' : 'password';
    var path1 = isHide
        ? 'M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88'
        : 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z';
    var path2 = isHide ? '' : 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z';
    btn.querySelector('svg').innerHTML =
        '<path stroke-linecap="round" stroke-linejoin="round" d="' + path1 + '"/>' +
        (path2 ? '<path stroke-linecap="round" stroke-linejoin="round" d="' + path2 + '"/>' : '');
}

function handleSubmit(form) {
    var btn     = document.getElementById('btn-submit');
    var text    = document.getElementById('btn-text');
    var spinner = document.getElementById('btn-spinner');
    btn.disabled = true;
    text.textContent = 'Mendaftar...';
    spinner.style.display = 'block';
}
</script>

</x-guest-layout>

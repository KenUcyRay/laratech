<h1>Profile</h1>

<h2>Informasi Pribadi</h2>
<p><strong>Nama:</strong> {{ $user->name }}</p>
<p><strong>Username:</strong> {{ $user->username }}</p>
<p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

<hr>

<h2>Ubah Password</h2>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif

<form action="{{ route('profile.password.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="current_password">Password Saat Ini</label>
        <br>
        <input type="password" name="current_password" id="current_password" required>
        @error('current_password')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>

    <div>
        <label for="password">Password Baru</label>
        <br>
        <input type="password" name="password" id="password" required>
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>

    <div>
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <br>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>
    <br>

    <button type="submit">Ubah Password</button>
</form>
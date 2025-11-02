@include('admin.layout.header')
<title>Setting Admin | BK</title>

<style>
    /* ==== PROFILE CARD STYLE ==== */

.profile-card {
    max-width: 550px;
    margin: 60px auto;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    padding: 40px 50px;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.profile-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

/* ==== HEADER ==== */
.profile-header {
    text-align: center;
    margin-bottom: 35px;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    font-weight: 600;
    color: #fff;
    margin: 0 auto 15px;
    box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
}

.profile-name {
    font-size: 22px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.profile-role {
    font-size: 14px;
    color: #777;
    font-style: italic;
}

/* ==== FORM ==== */
form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
    color: #444;
    margin-bottom: 6px;
}

.form-group input {
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 15px;
    color: #333;
    outline: none;
    transition: all 0.25s ease;
}

.form-group input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

/* ==== BUTTON ==== */
.btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border: none;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    background: linear-gradient(135deg, #5a6fe0, #6a3b9f);
    transform: scale(1.03);
}

/* ==== RESPONSIVE ==== */
@media (max-width: 600px) {
    .profile-card {
        padding: 30px 25px;
        max-width: 90%;
    }

    .profile-avatar {
        width: 75px;
        height: 75px;
        font-size: 32px;
    }

    .profile-name {
        font-size: 20px;
    }
}

</style>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr($admin->name, 0, 1)) }}
        </div>
        <h1 class="profile-name">{{ $admin->name }}</h1>
        <p class="profile-role">{{ $admin->getRoleDisplayAttribute() }}</p>
    </div>

    <form method="POST" action="{{ route('admin.setting.profile.update') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
        </div>

        <div class="form-group">
            <label for="current_password">Password Lama (untuk mengubah password)</label>
            <input type="password" id="current_password" name="current_password">
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>

@include('admin.layout.footer')

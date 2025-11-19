<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun | Barang Karung</title>

    <!-- Google Fonts & Material Icons -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth/register-style.css') }}">
</head>

<body>
    <!-- ===== REGISTER CONTAINER ===== -->
    <div class="register-container">
        <div class="register-card">
            <!-- ===== LEFT SECTION (FORM) ===== -->
            <div class="form-section">
                <div class="form-header">
                    <h1>Buat Akun Baru</h1>
                    <p>Bergabunglah dengan komunitas Barang Karung ID</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form class="register-form" action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <!-- ===== KOLOM KIRI ===== -->
                    <div class="form-columns">
                        <div class="form-column left-column">
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">person</span>
                                    <input type="text" name="name" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">home</span>
                                    <input type="text" name="address" placeholder="Masukkan alamat lengkap" required>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="form-group">
                                <label class="form-label">No. Telepon</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">phone</span>
                                    <input type="tel" name="phone" placeholder="Masukkan nomor telepon" required>
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="form-group">
                                <label class="form-label">Agama</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">church</span>
                                    <select name="religion" required>
                                        <option value="">Pilih agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ===== KOLOM KANAN ===== -->
                        <div class="form-column right-column">
                            <!-- Tanggal Lahir -->
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">cake</span>
                                    <input type="date" name="birth_date" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">person_outline</span>
                                    <select name="gender" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">email</span>
                                    <input type="email" name="email" placeholder="Masukkan email" required>
                                </div>
                            </div>

                            <!-- Profesi -->
                            <div class="form-group">
                                <label class="form-label">Profesi</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">work</span>
                                    <input type="text" name="profession" placeholder="Masukkan profesi" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== PASSWORD SECTION ===== -->
                    <div class="password-section">
                        <h3 class="section-title">Informasi Keamanan</h3>

                        <div class="password-columns">
                            <!-- Password -->
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">lock</span>
                                    <input type="password" name="password" id="password" placeholder="Masukkan password"
                                        required>
                                    <span class="material-icons toggle-password"
                                        onclick="togglePassword()">visibility_off</span>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="material-icons input-icon">lock</span>
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                        placeholder="Konfirmasi password" required>
                                    <span class="material-icons toggle-password"
                                        onclick="toggleConfirmPassword()">visibility_off</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-register">
                        <span class="btn-text">Daftar Sekarang</span>
                        <span class="material-icons btn-icon">arrow_forward</span>
                    </button>

                    <!-- Login Link -->
                    <div class="login-link">
                        <p>Sudah punya akun? <a href="{{ route('login') }}" class="link">Masuk di sini</a></p>
                    </div>
                </form>
            </div>

            <!-- ===== RIGHT SECTION (BRAND) ===== -->
            <div class="brand-section">
                <div class="brand-content">
                    <div class="brand-logo">
                        <img src="{{ asset('img/logo-katalog_pustaka.png') }}" alt="Barang Karung ID" class="logo-img">
                    </div>
                    <h2>Barang Karung ID</h2>
                    <p class="brand-tagline">Temukan Fashion Terbaik untuk Gaya Anda</p>
                    <div class="brand-features">
                        <div class="feature-item">
                            <span class="material-icons feature-icon">shopping_bag</span>
                            <span>Belanja Mudah & Aman</span>
                        </div>
                        <div class="feature-item">
                            <span class="material-icons feature-icon">local_shipping</span>
                            <span>Pengiriman Cepat</span>
                        </div>
                        <div class="feature-item">
                            <span class="material-icons feature-icon">support_agent</span>
                            <span>Customer Service 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== JAVASCRIPT ===== -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility_off';
            }
        }

        function toggleConfirmPassword() {
            const passwordInput = document.getElementById('confirmPassword');
            const toggleIcon = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility_off';
            }
        }

        // Form validation
        document.querySelector('.register-form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.querySelector('input[name="terms"]').checked;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }

            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan!');
                return;
            }
        });

        // Smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>
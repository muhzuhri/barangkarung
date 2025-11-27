<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'religion' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'profession' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
            'address.required' => 'Alamat harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'religion.required' => 'Agama harus dipilih',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'profession.required' => 'Profesi harus diisi',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'religion' => $request->religion,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'profession' => $request->profession,
        ]);

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun yang baru dibuat.');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('manual-auth.login');
    }

    /**
     * Handle login (unified for both users and admins)
     */
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // First, try to login as admin
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $admin = Auth::guard('admin')->user();
            
            // Check if admin is active
            if (!$admin->isActive()) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Akun admin tidak aktif. Silakan hubungi super admin.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')->with('success', 'Login admin berhasil! Selamat datang kembali.');
        }

        // If not admin, try to login as regular user
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('beranda'))->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle logout (unified for both users and admins)
     */
    public function logout(Request $request)
    {
        // Check if user is admin
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
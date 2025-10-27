<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::withCount(['carts'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $admin = auth('admin')->user();
        
        return view('admin.users.index', compact('users', 'admin'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $admin = auth('admin')->user();
        return view('admin.users.create', compact('admin'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'religion' => 'nullable|string|max:50',
            'profession' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            Log::error('User validation failed: ' . json_encode($validator->errors()));
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->all();
        $userData['password'] = Hash::make($request->password);

        $user = User::create($userData);
        Log::info('User created with ID: ' . $user->id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan!',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with(['carts.product'])
            ->findOrFail($id);
        $admin = auth('admin')->user();
        
        return view('admin.users.show', compact('user', 'admin'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $admin = auth('admin')->user();
        
        return view('admin.users.edit', compact('user', 'admin'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'religion' => 'nullable|string|max:50',
            'profession' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            Log::error('User update validation failed: ' . json_encode($validator->errors()));
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->all();
        
        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        } else {
            unset($userData['password']);
        }

        $user->update($userData);
        Log::info('User updated with ID: ' . $user->id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui!',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has carts
        if ($user->carts()->count() > 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus user yang memiliki item di keranjang.'
                ], 400);
            }
            
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus user yang memiliki item di keranjang.');
        }

        $user->delete();
        Log::info('User deleted with ID: ' . $id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
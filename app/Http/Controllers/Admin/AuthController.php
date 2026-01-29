<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     * Proses autentikasi admin
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil data admin
        $admin = DB::table('admins')
            ->where('username', $request->username)
            ->first();

        // Cek login
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()
                ->withInput()
                ->with('error', 'Username atau password salah');
        }

        // Simpan session admin
        session([
            'admin_logged_in' => true,
            'admin_id'        => $admin->id,
            'admin_name'      => $admin->name,
        ]);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->forget([
            'admin_logged_in',
            'admin_id',
            'admin_name',
        ]);

        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasCategory;
use App\Models\Pengaduan;
use App\Mail\PengaduanBaruAdminMail;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Form Pengaduan
    |--------------------------------------------------------------------------
    */
    public function create($id)
    {
        $category = FasilitasCategory::findOrFail($id);

        return view('pengaduan', compact('category'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Pengaduan
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fasilitas_category_id' => 'required|exists:fasilitas_categories,id',
            'nama_mahasiswa'        => 'required|string|max:255',
            'nim'                   => 'required|string|max:50',
            'email'                 => 'required|email',
            'judul'                 => 'required|string|max:255',
            'deskripsi'             => 'required|string',
            'lokasi'                => 'nullable|string|max:255',
            'foto'                  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /*
        | Upload Foto (jika ada)
        */
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->store('pengaduan', 'public');
        }

        /*
        | Generate Nomor Tiket
        */
        $lastId     = Pengaduan::max('id') + 1;
        $nomorTiket = 'PGD-' . now()->format('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        /*
        | Simpan ke Database
        */
        $pengaduan = Pengaduan::create([
            ...$validated,
            'foto'        => $fotoPath,
            'nomor_tiket' => $nomorTiket,
            'status'      => 'pending',
        ]);

        /*
        | Redirect ke Halaman Sukses
        */

        Mail::to(config('mail.admin_email'))
        ->send(new PengaduanBaruAdminMail($pengaduan));

        return redirect()
            ->route('pengaduan.sukses', $pengaduan->id)
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman Sukses
    |--------------------------------------------------------------------------
    */
    public function success($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        return view('sukses', compact('pengaduan'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tracking
    |--------------------------------------------------------------------------
    */
    public function trackingForm()
    {
        return view('tracking');
    }

    /*
    |--------------------------------------------------------------------------
    | Hasil Tracking
    |--------------------------------------------------------------------------
    */
    public function trackingResult(Request $request)
    {
        $request->validate([
            'nomor_tiket' => 'required|string',
        ]);

        $pengaduan = Pengaduan::where('nomor_tiket', $request->nomor_tiket)->first();

        if (!$pengaduan) {
            return back()->with('error', 'Nomor tiket tidak ditemukan.');
        }

        return view('tracking-hasil', compact('pengaduan'));
    }

    /*
    |--------------------------------------------------------------------------
    | Daftar Semua Pengaduan (Public)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $pengaduan = Pengaduan::with('category')
        ->latest()
        ->get(); 

    return view('pengaduan.index', compact('pengaduan'));
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Pengaduan (Public)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $pengaduan = Pengaduan::with('category')->findOrFail($id);

        return view('pengaduan.show', compact('pengaduan'));
    }
}

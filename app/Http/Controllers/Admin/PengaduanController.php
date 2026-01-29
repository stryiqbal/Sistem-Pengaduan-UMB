<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\StatusPengaduanMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Log;

class PengaduanController extends Controller
{
    // =============================
    // LIST PENGADUAN
    // =============================
    public function index()
    {
        $pengaduans = DB::table('pengaduans')
            ->join(
                'fasilitas_categories',
                'pengaduans.fasilitas_category_id',
                '=',
                'fasilitas_categories.id'
            )
            ->select(
                'pengaduans.id',
                'pengaduans.nomor_tiket',
                'pengaduans.nama_mahasiswa',
                'pengaduans.nim',
                'pengaduans.status',
                'pengaduans.created_at',
                'fasilitas_categories.title as kategori'
            )
            ->orderBy('pengaduans.created_at', 'desc')
            ->get();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    // =============================
    // DETAIL PENGADUAN
    // =============================
    public function show($id)
    {
        $pengaduan = DB::table('pengaduans')
            ->join(
                'fasilitas_categories',
                'pengaduans.fasilitas_category_id',
                '=',
                'fasilitas_categories.id'
            )
            ->select(
                'pengaduans.*',
                'fasilitas_categories.title as kategori'
            )
            ->where('pengaduans.id', $id)
            ->first();

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    // =============================
    // UPDATE STATUS + KIRIM EMAIL
    // =============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        // UPDATE STATUS
        DB::table('pengaduans')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

        $pengaduan = Pengaduan::findOrFail($id);

        try {
            if ($pengaduan->email) {
                Mail::to($pengaduan->email)
                    ->send(new StatusPengaduanMail($pengaduan));
            }
        } catch (\Exception $e) {
            Log::error('Email status pengaduan gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Status diperbarui. Notifikasi email dikirim jika alamat valid.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================
        // STATISTIK RINGKAS
        // ==========================
        $total    = DB::table('pengaduans')->count();
        $pending  = DB::table('pengaduans')->where('status', 'pending')->count();
        $diproses = DB::table('pengaduans')->where('status', 'diproses')->count();
        $selesai  = DB::table('pengaduans')->where('status', 'selesai')->count();

        // ==========================
        // TREN LAPORAN PER STATUS (12 BULAN)
        // ==========================
        $tahunAktif = now()->year;
        $labels = [];
        $dataPending = [];
        $dataDiproses = [];
        $dataSelesai = [];

        for ($m = 1; $m <= 12; $m++) {
            // Membuat label bulan (Jan, Feb, Mar...)
            $labels[] = Carbon::create()->month($m)->translatedFormat('M');

            // Hitung data per status untuk setiap bulan secara spesifik
            $dataPending[] = DB::table('pengaduans')
                ->whereYear('created_at', $tahunAktif)
                ->whereMonth('created_at', $m)
                ->where('status', 'pending')
                ->count();

            $dataDiproses[] = DB::table('pengaduans')
                ->whereYear('created_at', $tahunAktif)
                ->whereMonth('created_at', $m)
                ->where('status', 'diproses')
                ->count();

            $dataSelesai[] = DB::table('pengaduans')
                ->whereYear('created_at', $tahunAktif)
                ->whereMonth('created_at', $m)
                ->where('status', 'selesai')
                ->count();
        }

        return view('admin.dashboard', compact(
            'total',
            'pending',
            'diproses',
            'selesai',
            'labels',
            'dataPending',
            'dataDiproses',
            'dataSelesai',
            'tahunAktif'
        ));
    }
}
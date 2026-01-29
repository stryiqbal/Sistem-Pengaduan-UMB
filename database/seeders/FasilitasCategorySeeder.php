<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class FasilitasCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['building','Fasilitas Umum','Toilet, parkir, mushola, lift, taman'],
            ['door-open','Ruang Kelas','Meja, kursi, AC, proyektor, papan tulis'],
            ['flask','Laboratorium','Alat praktikum, komputer, software lab'],
            ['book','Perpustakaan','Buku, ruang baca, sistem peminjaman'],
            ['wifi','Teknologi & IT','WiFi, sistem akademik, e-learning'],
            ['cup-hot','Kantin','Kebersihan, meja kursi, fasilitas makan'],
            ['shield-lock','Keamanan','Satpam, CCTV, parkir, kehilangan'],
            ['heart-pulse','Kesehatan Kampus','UKS, P3K, layanan kesehatan'],
            ['trophy','Olahraga & UKM','Lapangan, GOR, ruang kegiatan'],
            ['person-workspace','Administrasi','Loket layanan, ruang tunggu'],
            ['three-dots','Lainnya','Fasilitas di luar kategori'],
        ];

        foreach ($categories as $cat) {
            DB::table('fasilitas_categories')->insert([
                'icon' => $cat[0],
                'title' => $cat[1],
                'slug' => Str::slug($cat[1]),
                'desc' => $cat[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

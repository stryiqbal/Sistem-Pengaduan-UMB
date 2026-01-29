<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FasilitasCategory;

class Pengaduan extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'fasilitas_category_id',
        'nama_mahasiswa',
        'nim',
        'email',
        'judul',
        'deskripsi',
        'lokasi',
        'foto',
        'nomor_tiket',
        'status',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Relationship: Pengaduan belongs to Fasilitas Category.
     */
    public function category()
    {
        return $this->belongsTo(
            FasilitasCategory::class,
            'fasilitas_category_id'
        );
    }
}

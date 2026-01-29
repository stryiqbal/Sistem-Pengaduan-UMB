<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasCategory extends Model
{
    protected $table = 'fasilitas_categories';

    protected $fillable = [
        'icon',
        'title',
        'slug',
        'desc'
    ];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }
}


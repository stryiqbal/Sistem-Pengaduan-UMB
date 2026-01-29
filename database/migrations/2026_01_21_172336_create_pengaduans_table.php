<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fasilitas_category_id')
                  ->constrained('fasilitas_categories')
                  ->cascadeOnDelete();

            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('email');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->enum('status',['pending','diproses','selesai'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'approver']);
            $table->tinyInteger('approver_level')->nullable(); // tambahan
            $table->timestamps();
        });

        // Kendaraan
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_plat');
            $table->string('jenis'); // angkutan orang/barang
            $table->string('merk');
            $table->year('tahun');
            $table->string('lokasi')->nullable(); // ✅ tambahan lokasi
            $table->date('tanggal_terakhir_bbm')->nullable();
            $table->date('tanggal_terakhir_service')->nullable();
            $table->integer('km_terakhir')->nullable();
            $table->date('jadwal_service_berikutnya')->nullable();
            $table->enum('status', ['aktif', 'servis', 'rusak'])->default('aktif');
            $table->timestamps();
        });

        // Driver
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telp');
            $table->timestamps();
        });

        // Pemesanan
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->date('tanggal_pakai');
            $table->string('lokasi');
            $table->enum('status', ['pending', 'ditolak', 'disetujui', 'kembalikan', 'selesai'])->default('pending');
            $table->timestamps();
        });

        // Approval
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan');
            $table->foreignId('approver_id')->constrained('users');
            $table->unsignedTinyInteger('level');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_approve')->nullable();
            $table->timestamps();
        });

        // Riwayat Kendaraan
        Schema::create('riwayat_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
            $table->foreignId('pemesanan_id')->constrained('pemesanan');
            $table->integer('km_awal');
            $table->integer('km_akhir');
            $table->integer('bbm_pakai');
            $table->datetime('tanggal_mulai')->nullable();
            $table->datetime('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Jadwal Service
        Schema::create('jadwal_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
            $table->date('tanggal_service');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });

        // Log Aktivitas
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('aktivitas');
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
        Schema::dropIfExists('jadwal_service');
        Schema::dropIfExists('riwayat_kendaraan');
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('pemesanan');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('kendaraan');
        Schema::dropIfExists('users');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->timestamps();
        });

        // Seed initial site pages
        DB::table('site_pages')->insert([
            [
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => "Welcome to University News Portal, the authoritative source for academic reporting, intellectual discourse, and institutional breakthroughs across higher education.\n\nOur platform connects students, researchers, faculty, and university stakeholders with the latest news, achievements, research innovations, and academic events.",
                'vision' => "To become the global premier news and knowledge platform bridging academic institutions, researchers, and the public.",
                'mission' => "Deliver high-integrity academic reporting and institutional news.\nEmpower scholars and students by amplifying groundbreaking research.\nFoster collaboration and engagement across diverse university communities.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Kebijakan Privasi',
                'content' => "Kebijakan privasi ini menjelaskan bagaimana University News Portal (\"kami\") mengumpulkan, menggunakan, dan melindungi data pribadi yang Anda berikan melalui situs ini.\n\nData yang Kami Kumpulkan\n- Nama, alamat email, dan informasi profil yang Anda isikan pada pendaftaran akun atau formulir pengajuan author\n- Kategori minat, artikel yang Anda simpan, dan pesan yang Anda kirimkan\n\nPenggunaan Data\nData yang Anda kirimkan melalui platform digunakan semata-mata untuk memproses akun Anda, mempublikasikan artikel, serta layanan platform, dan tidak dibagikan kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.\n\nHubungi Kami\nPertanyaan seputar kebijakan privasi ini dapat disampaikan melalui halaman Kontak Kami.",
                'vision' => null,
                'mission' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pages');
    }
};

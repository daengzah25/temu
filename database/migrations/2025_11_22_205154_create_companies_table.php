<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('logo')->nullable(); // Foto profil UMKM
            $table->string('category'); // Makanan, Fashion, Jasa, dll
            $table->text('description')->nullable();
            $table->text('address');
            $table->decimal('latitude', 10, 7); // Lokasi GPS
            $table->decimal('longitude', 10, 7);
            $table->string('whatsapp');
            $table->string('operating_hours')->nullable(); // "08:00-21:00"
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();

            // Index untuk pencarian nearby
            $table->index(['latitude', 'longitude']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('prompt'); // Input user
            $table->text('result'); // Output AI
            $table->string('platform')->nullable(); // Instagram, WhatsApp, Facebook
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_promotions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_settings', function (Blueprint $table) {
            $table->id();
            $table->string('director_name')->nullable();
            $table->string('director_signature')->nullable(); // path on public disk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_settings');
    }
};


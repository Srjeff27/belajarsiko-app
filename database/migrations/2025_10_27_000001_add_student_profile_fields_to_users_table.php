<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npm')->nullable()->after('role');
            $table->unsignedTinyInteger('semester')->nullable()->after('npm');
            $table->string('kelas')->nullable()->after('semester');
            $table->string('program_studi')->nullable()->after('kelas');
            $table->string('fakultas')->nullable()->after('program_studi');
            $table->string('universitas')->nullable()->after('fakultas');
            $table->string('wa_number')->nullable()->after('universitas');
            $table->string('alamat', 500)->nullable()->after('wa_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'npm',
                'semester',
                'kelas',
                'program_studi',
                'fakultas',
                'universitas',
                'wa_number',
                'alamat',
            ]);
        });
    }
};


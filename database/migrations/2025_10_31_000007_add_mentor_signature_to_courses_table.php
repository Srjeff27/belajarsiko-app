<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('mentor_signature_name')->nullable()->after('status');
            $table->string('mentor_signature')->nullable()->after('mentor_signature_name');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['mentor_signature_name', 'mentor_signature']);
        });
    }
};


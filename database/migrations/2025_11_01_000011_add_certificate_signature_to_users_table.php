<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'certificate_signature_name')) {
                $table->string('certificate_signature_name')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'certificate_signature')) {
                $table->string('certificate_signature')->nullable()->after('certificate_signature_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['certificate_signature', 'certificate_signature_name'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};


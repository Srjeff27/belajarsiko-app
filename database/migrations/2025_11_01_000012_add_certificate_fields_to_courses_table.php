<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'certificate_total_jp')) {
                $table->unsignedInteger('certificate_total_jp')->nullable()->after('mentor_signature');
            }
            if (!Schema::hasColumn('courses', 'certificate_competencies')) {
                $table->json('certificate_competencies')->nullable()->after('certificate_total_jp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            foreach (['certificate_competencies', 'certificate_total_jp'] as $col) {
                if (Schema::hasColumn('courses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};


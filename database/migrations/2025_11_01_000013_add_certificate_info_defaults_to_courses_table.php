<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'certificate_type')) {
                $table->string('certificate_type')->nullable()->after('certificate_competencies');
            }
            if (!Schema::hasColumn('courses', 'certificate_number_prefix')) {
                $table->string('certificate_number_prefix')->nullable()->after('certificate_type');
            }
            if (!Schema::hasColumn('courses', 'certificate_course_subtitle')) {
                $table->string('certificate_course_subtitle')->nullable()->after('certificate_number_prefix');
            }
            if (!Schema::hasColumn('courses', 'certificate_assessed_at')) {
                $table->timestamp('certificate_assessed_at')->nullable()->after('certificate_course_subtitle');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            foreach ([
                'certificate_assessed_at', 'certificate_course_subtitle', 'certificate_number_prefix', 'certificate_type',
            ] as $col) {
                if (Schema::hasColumn('courses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};


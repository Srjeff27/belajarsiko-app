<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('certificate_settings', 'default_certificate_type')) {
                $table->string('default_certificate_type')->nullable()->after('director_signature');
            }
            if (!Schema::hasColumn('certificate_settings', 'default_number_prefix')) {
                $table->string('default_number_prefix')->nullable()->after('default_certificate_type');
            }
            if (!Schema::hasColumn('certificate_settings', 'default_course_subtitle')) {
                $table->string('default_course_subtitle')->nullable()->after('default_number_prefix');
            }
            if (!Schema::hasColumn('certificate_settings', 'default_total_jp')) {
                $table->unsignedInteger('default_total_jp')->nullable()->after('default_course_subtitle');
            }
            if (!Schema::hasColumn('certificate_settings', 'default_assessed_at')) {
                $table->timestamp('default_assessed_at')->nullable()->after('default_total_jp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('certificate_settings', function (Blueprint $table) {
            foreach ([
                'default_assessed_at', 'default_total_jp', 'default_course_subtitle', 'default_number_prefix', 'default_certificate_type',
            ] as $col) {
                if (Schema::hasColumn('certificate_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};


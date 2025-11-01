<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'type')) {
                $table->string('type')->nullable()->after('google_drive_link'); // KELULUSAN/KOMPETENSI
            }
            if (!Schema::hasColumn('certificates', 'formal_number')) {
                $table->string('formal_number')->nullable()->after('type');
            }
            if (!Schema::hasColumn('certificates', 'course_subtitle')) {
                $table->string('course_subtitle')->nullable()->after('formal_number');
            }
            if (!Schema::hasColumn('certificates', 'total_jp')) {
                $table->unsignedInteger('total_jp')->nullable()->after('course_subtitle');
            }
            if (!Schema::hasColumn('certificates', 'competencies')) {
                $table->json('competencies')->nullable()->after('total_jp');
            }
            if (!Schema::hasColumn('certificates', 'assessed_at')) {
                $table->timestamp('assessed_at')->nullable()->after('competencies');
            }
            if (!Schema::hasColumn('certificates', 'mentor_signature_name')) {
                $table->string('mentor_signature_name')->nullable()->after('assessed_at');
            }
            if (!Schema::hasColumn('certificates', 'mentor_signature')) {
                $table->string('mentor_signature')->nullable()->after('mentor_signature_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            foreach ([
                'mentor_signature', 'mentor_signature_name', 'assessed_at', 'competencies',
                'total_jp', 'course_subtitle', 'formal_number', 'type',
            ] as $col) {
                if (Schema::hasColumn('certificates', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};


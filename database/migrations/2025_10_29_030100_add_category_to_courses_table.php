<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'course_category_id')) {
                $table->foreignId('course_category_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('course_categories')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'course_category_id')) {
                $table->dropConstrainedForeignId('course_category_id');
            }
        });
    }
};


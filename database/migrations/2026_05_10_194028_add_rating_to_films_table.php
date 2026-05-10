<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(0)->after('poster');
            $table->integer('rating_count')->default(0)->after('rating');
            $table->string('age_rating')->default('PG-13')->after('rating_count');
        });
    }

    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropColumn(['rating', 'rating_count', 'age_rating']);
        });
    }
};
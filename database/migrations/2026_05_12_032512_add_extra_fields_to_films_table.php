<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->string('trailer')->nullable()->after('poster');
            $table->string('director')->nullable()->after('trailer');
            $table->string('cast')->nullable()->after('director'); 
            $table->string('backdrop')->nullable()->after('cast');
            $table->date('release_date')->nullable()->after('backdrop');
            $table->enum('status', ['now_showing', 'coming_soon'])->default('now_showing')->after('release_date');
        });
    }

    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropColumn(['trailer', 'director', 'cast', 'backdrop', 'release_date', 'status']);
        });
    }
};
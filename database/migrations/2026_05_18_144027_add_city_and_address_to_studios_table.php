<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            if (!Schema::hasColumn('studios', 'city')) {
                $table->string('city')->default('LAMPUNG')->after('nama');
            }

            if (!Schema::hasColumn('studios', 'address')) {
                $table->string('address')->nullable()->after('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            if (Schema::hasColumn('studios', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('studios', 'city')) {
                $table->dropColumn('city');
            }
        });
    }
};
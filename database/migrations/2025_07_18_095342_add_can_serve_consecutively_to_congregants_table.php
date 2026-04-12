<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('congregants', function (Blueprint $table) {
            $table->boolean('can_serve_consecutively')->default(false)->after('status')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('congregants', function (Blueprint $table) {
            $table->dropColumn('can_serve_consecutively');
        });
    }
};

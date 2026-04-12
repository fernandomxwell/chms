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
        Schema::create('congregant_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('congregant_id');
            $table->unsignedBigInteger('activity_id');
            $table->timestamps();

            $table->unique(['congregant_id', 'activity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congregant_activities');
    }
};

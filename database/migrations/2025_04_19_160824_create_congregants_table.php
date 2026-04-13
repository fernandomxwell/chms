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
        Schema::create('congregants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100)->index();
            $table->enum('gender', ['male', 'female'])->index();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 20)->nullable()->index();
            $table->string('email', 100)->nullable()->index();
            $table->date('date_of_baptism')->nullable();
            $table->enum('status', ['member', 'sympathizer'])->default('sympathizer')->index();
            $table->boolean('can_serve_consecutively')->default(false)->index();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congregants');
    }
};

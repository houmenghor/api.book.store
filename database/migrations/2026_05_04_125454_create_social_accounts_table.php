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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider_name', 50);
            $table->string('provider_user_id', 255);
            $table->string('provider_email', 255)->nullable();
            $table->string('provider_avatar', 2048)->nullable();
            $table->timestamps();

            $table->unique(['provider_name', 'provider_user_id']);
            $table->unique(['user_id', 'provider_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};

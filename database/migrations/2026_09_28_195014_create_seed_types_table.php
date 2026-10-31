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
        Schema::create('seed_types', function (Blueprint $table) {
            $table->id('idSeedType');
            $table->string('typeOfSeed')->default('normal');
            $table->integer('care_per_level')->default(5);
            $table->integer('harvest_reward_in_coins')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seed_types');
    }
};

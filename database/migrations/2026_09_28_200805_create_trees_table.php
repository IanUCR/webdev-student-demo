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
        Schema::create('trees', function (Blueprint $table) {
            $table->id('idTree');
            $table->foreignId('idSeed')->constrained('seeds');
            $table->foreignId('owner_id')->constrained('users');
            $table->integer('level')->default(0);
            $table->integer('health')->default(100);
            $table->integer('progress')->default(0);
            $table->string('status')->default('Active');
            $table->timestamps('last_cared_at')->nullable();
            $table->timestamps('next_cared_at')->nullable();
            $table->timestamps('last_decay_at')->nullable();
            $table->timestamp('last_harvested_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trees');
    }
};

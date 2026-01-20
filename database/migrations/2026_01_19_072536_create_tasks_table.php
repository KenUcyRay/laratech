<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('equipment_id')->constrained('equipments');
            $table->foreignUuid('assigned_to')->constrained('users'); // operator/teknisi
            $table->string('title');
            $table->string('status'); // todo, doing, done, cancelled
            $table->string('priority'); // low, medium, high
            $table->timestamp('due_date')->nullable(); // deadline
            $table->timestamp('started_at')->nullable(); // waktu mulai dikerjakan
            $table->timestamp('completed_at')->nullable(); // waktu selesai dikerjakan
            $table->timestamp('cancelled_at')->nullable(); // jika dibatalkan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

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
        Schema::create('equipments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique(); //kode alat
            $table->string('name');
            $table->foreignUuid('equipment_type_id')->constrained('equipment_types');
            $table->string('status'); //idle, operasi, rusak, servis
            $table->integer('hour_meter')->default(0); //jam kerja
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};

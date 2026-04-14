<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chirps', function (Blueprint $table) {
            $table->id(); // auto-generated
            $table
            ->foreignId('user_id')
            ->nullable() // nullable for dev
            ->constrained()
            ->cascadeOnDelete(); // user deleted, chirps deleted too
            $table->string('message', 255);
            $table->timestamps(); // auto-generated, created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chirps');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('polyclinic_id')
                ->constrained('polyclinics')
                ->restrictOnDelete();

            $table->string('name', 150);
            $table->string('specialization', 100)->nullable();
            $table->string('phone', 20)->nullable();

            $table->timestamps();

            $table->unique(['id', 'polyclinic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

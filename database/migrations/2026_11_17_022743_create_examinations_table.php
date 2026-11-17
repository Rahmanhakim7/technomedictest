
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registration_id')
                ->unique()
                ->constrained('registrations')
                ->restrictOnDelete();

            $table->text('complaint')->nullable();

            $table->smallInteger('systolic')->nullable();
            $table->smallInteger('diastolic')->nullable();
            $table->smallInteger('pulse')->nullable();

            $table->decimal('temperature', 4, 1)->nullable();

            $table->smallInteger('respiratory_rate')->nullable();

            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();

            $table->timestamp('examined_at')->nullable();
            $table->string('examiner_name', 150);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};

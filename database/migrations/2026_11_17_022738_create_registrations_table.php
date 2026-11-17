
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('registration_number', 30)->unique();
            $table->date('visit_date');

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->restrictOnDelete();

            $table->foreignId('doctor_id');

            $table->foreignId('polyclinic_id')
                ->constrained('polyclinics')
                ->restrictOnDelete();

            $table->foreign(['doctor_id', 'polyclinic_id'])
                ->references(['id', 'polyclinic_id'])
                ->on('doctors')
                ->restrictOnDelete();

            $table->string('payment_type', 10);
            $table->text('main_complaint');
            $table->string('status', 20)->default('MENUNGGU');

            $table->timestamps();

            $table->index(['visit_date', 'status']);
            $table->index(['polyclinic_id', 'visit_date']);
        });

        DB::statement("
            ALTER TABLE registrations
            ADD CONSTRAINT registrations_payment_type_check
            CHECK (payment_type IN ('UMUM', 'BPJS'))
        ");

        DB::statement("
            ALTER TABLE registrations
            ADD CONSTRAINT registrations_status_check
            CHECK (status IN ('MENUNGGU', 'DIPERIKSA', 'SELESAI', 'BATAL'))
        ");

        DB::statement("
            CREATE UNIQUE INDEX registrations_unique_active_patient_doctor
            ON registrations (patient_id, doctor_id)
            WHERE status IN ('MENUNGGU', 'DIPERIKSA')
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};

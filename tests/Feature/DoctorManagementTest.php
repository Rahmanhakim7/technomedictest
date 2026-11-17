<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_doctors(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Siti',
            'specialization' => 'Dokter Umum',
        ]);

        $this->get(route('doctors.index'))
            ->assertOk()
            ->assertSee($doctor->name)
            ->assertSee($polyclinic->name)
            ->assertSee('action="'.route('doctors.destroy', $doctor->id).'"', false);
    }

    public function test_index_locks_delete_for_doctor_with_registration_history(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Riwayat',
        ]);
        $this->createRegistrationFor($doctor, $polyclinic);

        $this->get(route('doctors.index'))
            ->assertOk()
            ->assertSee('Terkunci')
            ->assertDontSee('action="'.route('doctors.destroy', $doctor->id).'"', false);
    }

    public function test_create_page_renders(): void
    {
        Polyclinic::create(['name' => 'Poliklinik Umum']);

        $this->get(route('doctors.create'))
            ->assertOk()
            ->assertSee('Tambah Dokter');
    }

    public function test_edit_page_renders(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Siti',
            'specialization' => 'Dokter Umum',
        ]);

        $this->get(route('doctors.edit', $doctor))
            ->assertOk()
            ->assertSee($doctor->name);
    }

    public function test_edit_page_locks_polyclinic_for_doctor_with_registration_history(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Riwayat',
        ]);
        $this->createRegistrationFor($doctor, $polyclinic);

        $this->get(route('doctors.edit', $doctor))
            ->assertOk()
            ->assertSee('Poliklinik tidak dapat diubah');
    }

    public function test_store_creates_doctor(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Anak']);

        $response = $this->post(route('doctors.store'), [
            'name' => 'dr. Budi',
            'specialization' => 'Anak',
            'phone' => '081234567890',
            'polyclinic_id' => $polyclinic->id,
        ]);

        $response->assertRedirect(route('doctors.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('doctors', [
            'name' => 'dr. Budi',
            'specialization' => 'Anak',
            'phone' => '081234567890',
            'polyclinic_id' => $polyclinic->id,
        ]);
    }

    public function test_store_requires_name_and_polyclinic(): void
    {
        $this->post(route('doctors.store'), [])
            ->assertSessionHasErrors(['name', 'polyclinic_id']);
    }

    public function test_store_rejects_unknown_polyclinic(): void
    {
        $this->post(route('doctors.store'), [
            'name' => 'dr. Tanpa Poli',
            'polyclinic_id' => 999,
        ])->assertSessionHasErrors('polyclinic_id');
    }

    public function test_update_updates_doctor(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Lama',
        ]);

        $response = $this->put(route('doctors.update', $doctor), [
            'name' => 'dr. Baru',
            'specialization' => 'Penyakit Dalam',
            'phone' => '089999999999',
            'polyclinic_id' => $polyclinic->id,
        ]);

        $response->assertRedirect(route('doctors.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('doctors', [
            'id' => $doctor->id,
            'name' => 'dr. Baru',
            'specialization' => 'Penyakit Dalam',
            'phone' => '089999999999',
        ]);
    }

    public function test_update_can_move_doctor_without_registration_history(): void
    {
        $firstPolyclinic = Polyclinic::create(['name' => 'Poliklinik Pertama']);
        $secondPolyclinic = Polyclinic::create(['name' => 'Poliklinik Kedua']);
        $doctor = Doctor::create([
            'polyclinic_id' => $firstPolyclinic->id,
            'name' => 'dr. Pindah',
        ]);

        $this->put(route('doctors.update', $doctor), [
            'name' => $doctor->name,
            'polyclinic_id' => $secondPolyclinic->id,
        ])->assertRedirect(route('doctors.index'));

        $this->assertDatabaseHas('doctors', [
            'id' => $doctor->id,
            'polyclinic_id' => $secondPolyclinic->id,
        ]);
    }

    public function test_update_rejects_moving_doctor_with_registration_history(): void
    {
        $firstPolyclinic = Polyclinic::create(['name' => 'Poliklinik Asal']);
        $secondPolyclinic = Polyclinic::create(['name' => 'Poliklinik Tujuan']);
        $doctor = Doctor::create([
            'polyclinic_id' => $firstPolyclinic->id,
            'name' => 'dr. Tetap',
        ]);
        $this->createRegistrationFor($doctor, $firstPolyclinic);

        $this->put(route('doctors.update', $doctor), [
            'name' => $doctor->name,
            'polyclinic_id' => $secondPolyclinic->id,
        ])->assertSessionHasErrors('polyclinic_id');

        $this->assertDatabaseHas('doctors', [
            'id' => $doctor->id,
            'polyclinic_id' => $firstPolyclinic->id,
        ]);
    }

    public function test_destroy_deletes_doctor_without_registration_history(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Hapus',
        ]);

        $response = $this->delete(route('doctors.destroy', $doctor));

        $response->assertRedirect(route('doctors.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
    }

    public function test_destroy_keeps_doctor_with_registration_history(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Umum']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Riwayat',
        ]);
        $this->createRegistrationFor($doctor, $polyclinic);

        $response = $this->delete(route('doctors.destroy', $doctor));

        $response->assertRedirect(route('doctors.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('doctors', ['id' => $doctor->id]);
    }

    private function createRegistrationFor(Doctor $doctor, Polyclinic $polyclinic): Registration
    {
        $sequence = Patient::count() + 1;

        $patient = Patient::create([
            'medical_record_number' => 'RM-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT),
            'nik' => (string) (3201010101010000 + $sequence),
            'full_name' => 'Pasien '.$doctor->name,
            'gender' => 'Laki-laki',
            'birth_date' => '1990-01-01',
        ]);

        return Registration::create([
            'registration_number' => 'REG-'.str_pad((string) (Registration::count() + 1), 4, '0', STR_PAD_LEFT),
            'visit_date' => now()->toDateString(),
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'polyclinic_id' => $polyclinic->id,
            'payment_type' => 'UMUM',
            'main_complaint' => 'Pemeriksaan rutin',
            'status' => 'SELESAI',
        ]);
    }
}

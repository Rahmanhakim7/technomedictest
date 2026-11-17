<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolyclinicManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_polyclinics(): void
    {
        $polyclinic = Polyclinic::create([
            'name' => 'Poliklinik Umum',
            'description' => 'Layanan pemeriksaan umum.',
        ]);

        $this->get(route('polyclinics.index'))
            ->assertOk()
            ->assertSee($polyclinic->name)
            ->assertSee('action="'.route('polyclinics.destroy', $polyclinic->id).'"', false);
    }

    public function test_index_locks_delete_for_polyclinic_in_use(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Terpakai']);

        Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Contoh',
        ]);

        $this->get(route('polyclinics.index'))
            ->assertOk()
            ->assertSee('Terkunci')
            ->assertDontSee('action="'.route('polyclinics.destroy', $polyclinic->id).'"', false);
    }

    public function test_create_page_renders(): void
    {
        $this->get(route('polyclinics.create'))
            ->assertOk()
            ->assertSee('Tambah Poliklinik');
    }

    public function test_edit_page_renders(): void
    {
        $polyclinic = Polyclinic::create([
            'name' => 'Poliklinik Umum',
            'description' => 'Layanan pemeriksaan umum.',
        ]);

        $this->get(route('polyclinics.edit', $polyclinic))
            ->assertOk()
            ->assertSee($polyclinic->name);
    }

    public function test_edit_page_shows_lock_note_when_polyclinic_is_in_use(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Terpakai']);

        Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Contoh',
        ]);

        $this->get(route('polyclinics.edit', $polyclinic))
            ->assertOk()
            ->assertSee('Poliklinik ini masih digunakan');
    }

    public function test_store_creates_polyclinic(): void
    {
        $response = $this->post(route('polyclinics.store'), [
            'name' => 'Poliklinik Gigi',
            'description' => 'Layanan kesehatan gigi dan mulut.',
        ]);

        $response->assertRedirect(route('polyclinics.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('polyclinics', [
            'name' => 'Poliklinik Gigi',
            'description' => 'Layanan kesehatan gigi dan mulut.',
        ]);
    }

    public function test_store_requires_name(): void
    {
        $this->post(route('polyclinics.store'), [
            'description' => 'Poliklinik tanpa nama.',
        ])->assertSessionHasErrors('name');
    }

    public function test_store_rejects_duplicate_name(): void
    {
        Polyclinic::create(['name' => 'Poliklinik Anak']);

        $this->post(route('polyclinics.store'), [
            'name' => 'Poliklinik Anak',
        ])->assertSessionHasErrors('name');
    }

    public function test_update_updates_polyclinic(): void
    {
        $polyclinic = Polyclinic::create([
            'name' => 'Poli Lama',
            'description' => 'Deskripsi lama.',
        ]);

        $response = $this->put(route('polyclinics.update', $polyclinic), [
            'name' => 'Poli Baru',
            'description' => 'Deskripsi baru.',
        ]);

        $response->assertRedirect(route('polyclinics.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('polyclinics', [
            'id' => $polyclinic->id,
            'name' => 'Poli Baru',
            'description' => 'Deskripsi baru.',
        ]);
    }

    public function test_update_allows_same_name_for_the_same_polyclinic(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Mata']);

        $this->put(route('polyclinics.update', $polyclinic), [
            'name' => 'Poliklinik Mata',
            'description' => 'Pemeriksaan mata.',
        ])->assertSessionHasNoErrors();
    }

    public function test_update_rejects_duplicate_name_from_another_polyclinic(): void
    {
        Polyclinic::create(['name' => 'Poliklinik Dalam']);
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Bedah']);

        $this->put(route('polyclinics.update', $polyclinic), [
            'name' => 'Poliklinik Dalam',
        ])->assertSessionHasErrors('name');
    }

    public function test_destroy_deletes_polyclinic_without_relations(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Sementara']);

        $response = $this->delete(route('polyclinics.destroy', $polyclinic));

        $response->assertRedirect(route('polyclinics.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('polyclinics', ['id' => $polyclinic->id]);
    }

    public function test_destroy_keeps_polyclinic_that_still_has_doctors(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Terpakai']);

        Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Contoh',
        ]);

        $response = $this->delete(route('polyclinics.destroy', $polyclinic));

        $response->assertRedirect(route('polyclinics.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('polyclinics', ['id' => $polyclinic->id]);
    }

    public function test_destroy_keeps_polyclinic_with_registration_history(): void
    {
        $polyclinic = Polyclinic::create(['name' => 'Poliklinik Riwayat']);
        $doctor = Doctor::create([
            'polyclinic_id' => $polyclinic->id,
            'name' => 'dr. Riwayat',
        ]);
        $patient = Patient::create([
            'medical_record_number' => 'RM-0001',
            'nik' => '3201010101010001',
            'full_name' => 'Pasien Riwayat',
            'gender' => 'Laki-laki',
            'birth_date' => '1990-01-01',
        ]);

        Registration::create([
            'registration_number' => 'REG-0001',
            'visit_date' => now()->toDateString(),
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'polyclinic_id' => $polyclinic->id,
            'payment_type' => 'UMUM',
            'main_complaint' => 'Pemeriksaan rutin',
            'status' => 'SELESAI',
        ]);

        $response = $this->delete(route('polyclinics.destroy', $polyclinic));

        $response->assertRedirect(route('polyclinics.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('polyclinics', ['id' => $polyclinic->id]);
    }
}

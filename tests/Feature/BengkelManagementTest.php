<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BengkelManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_defaults_to_user(): void
    {
        $user = User::factory()->create();

        $this->assertSame('user', $user->role);
    }

    public function test_admin_can_create_service(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.services.store'), [
                'name' => 'Tune Up Motor',
                'category' => 'motor',
                'price' => 250000,
                'duration_minutes' => 90,
                'description' => 'Pemeriksaan mesin dan penggantian oli.',
            ])
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', [
            'name' => 'Tune Up Motor',
            'category' => 'motor',
            'price' => 250000,
        ]);
    }

    public function test_authenticated_user_can_create_booking(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user)
            ->post(route('bookings.store'), [
                'service_id' => $service->id,
                'customer_name' => 'Ayu Pratama',
                'phone' => '081234567890',
                'vehicle_type' => 'motor',
                'plate_number' => 'B 9999 XYZ',
                'preferred_date' => '2026-10-15',
                'notes' => 'Cek rem depan.',
            ])
            ->assertRedirect(route('bookings.index'));

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'customer_name' => 'Ayu Pratama',
            'service_id' => $service->id,
        ]);
    }
}

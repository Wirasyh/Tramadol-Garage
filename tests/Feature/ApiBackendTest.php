<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiBackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_service_list_contains_active_services_only(): void
    {
        $activeService = Service::factory()->create(['name' => 'Tune Up']);
        Service::factory()->create(['name' => 'Layanan Nonaktif', 'is_active' => false]);

        $this->getJson('/api/v1/services')
            ->assertOk()
            ->assertJsonPath('data.0.id', $activeService->id)
            ->assertJsonCount(1, 'data');
    }

    public function test_public_service_detail_hides_inactive_services(): void
    {
        $service = Service::factory()->create(['is_active' => false]);

        $this->getJson("/api/v1/services/{$service->id}")->assertNotFound();
    }

    public function test_guest_cannot_create_a_booking(): void
    {
        $this->postJson('/api/v1/bookings', [])->assertUnauthorized();
    }

    public function test_user_can_log_in_and_read_their_session_profile_through_the_api(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-password'),
        ]);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'correct-password',
        ])
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonMissingPath('data.password');

        $this->getJson('/api/v1/auth/user')
            ->assertOk()
            ->assertJsonPath('data.email', $user->email);

        $this->postJson('/api/v1/auth/logout')->assertNoContent();

        $this->getJson('/api/v1/auth/user')->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_a_booking(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/v1/bookings', [
                'service_id' => $service->id,
                'customer_name' => 'Ayu Pratama',
                'phone' => '081234567890',
                'vehicle_type' => 'motor',
                'plate_number' => 'B 9999 XYZ',
                'preferred_date' => now()->addDay()->toDateString(),
                'notes' => 'Cek rem depan.',
            ])
            ->assertCreated()
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'customer_name' => 'Ayu Pratama',
            'status' => 'pending',
        ]);
    }

    public function test_booking_requires_an_active_service(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['is_active' => false]);

        $this->actingAs($user)
            ->postJson('/api/v1/bookings', [
                'service_id' => $service->id,
                'customer_name' => 'Ayu Pratama',
                'phone' => '081234567890',
                'vehicle_type' => 'motor',
                'plate_number' => 'B 9999 XYZ',
                'preferred_date' => now()->addDay()->toDateString(),
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('service_id');

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_customers_only_receive_their_own_bookings(): void
    {
        $user = User::factory()->create();
        $ownBooking = Booking::factory()->for($user)->create();
        Booking::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/v1/bookings')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $ownBooking->id)
            ->assertJsonMissingPath('data.0.user');
    }

    public function test_non_admin_cannot_create_a_service_through_the_api(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson('/api/v1/admin/services', [
                'name' => 'Tune Up Motor',
                'category' => 'motor',
                'price' => 250000,
                'duration_minutes' => 90,
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('services', 0);
    }

    public function test_admin_can_create_services_with_unique_slugs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = [
            'name' => 'Tune Up Motor',
            'category' => 'motor',
            'price' => 250000,
            'duration_minutes' => 90,
        ];

        $this->actingAs($admin)
            ->postJson('/api/v1/admin/services', $payload)
            ->assertCreated()
            ->assertJsonPath('data.slug', 'tune-up-motor');

        $this->postJson('/api/v1/admin/services', $payload)
            ->assertCreated()
            ->assertJsonPath('data.slug', 'tune-up-motor-2');

        $this->assertDatabaseCount('services', 2);
    }

    public function test_admin_can_update_booking_status_through_the_api(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patchJson("/api/v1/admin/bookings/{$booking->id}", ['status' => 'confirmed'])
            ->assertOk()
            ->assertJsonPath('data.status', 'confirmed');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_invalid_booking_status_does_not_change_the_booking(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patchJson("/api/v1/admin/bookings/{$booking->id}", ['status' => 'forged'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('status');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_cannot_delete_a_service_used_by_existing_bookings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create();

        $this->actingAs($admin)
            ->deleteJson("/api/v1/admin/services/{$booking->service_id}")
            ->assertConflict();

        $this->assertModelExists($booking);
        $this->assertModelExists($booking->service);
    }

    public function test_database_restricts_deleting_a_service_used_by_existing_bookings(): void
    {
        $booking = Booking::factory()->create();

        try {
            $booking->service->delete();
            $this->fail('A service referenced by a booking must not be deleted.');
        } catch (QueryException) {
            $this->assertModelExists($booking);
            $this->assertModelExists($booking->service);
        }
    }

    public function test_admin_can_be_promoted_by_email_using_the_console_command(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->artisan('app:promote-user-to-admin', ['email' => $user->email])
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'admin',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_update_a_booking_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->get(route('admin.bookings.index'))
            ->assertOk()
            ->assertSee($booking->customer_name);

        $this->patch(route('admin.bookings.update', $booking), ['status' => 'confirmed'])
            ->assertRedirect(route('admin.bookings.index'));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_regular_user_cannot_manage_bookings(): void
    {
        $booking = Booking::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.bookings.index'))
            ->assertForbidden();

        $this->patch(route('admin.bookings.update', $booking), ['status' => 'confirmed'])
            ->assertForbidden();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_cannot_delete_a_service_used_by_a_booking(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.services.destroy', $booking->service))
            ->assertRedirect();

        $this->assertModelExists($booking);
        $this->assertModelExists($booking->service);
    }
}

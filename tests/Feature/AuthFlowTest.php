<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_and_login_form_are_available_to_guests(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Rawat hari ini.')
            ->assertSee(route('login'));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Selamat datang')
            ->assertSee(route('login.store'));

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Buat akun')
            ->assertSee(route('register.store'));
    }

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_sign_in_and_sign_out(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('service-secret'),
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'service-secret',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk()->assertSee($user->name);

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_invalid_credentials_do_not_sign_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('service-secret'),
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_visitor_can_register_and_is_signed_in(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Ayu Pratama',
            'email' => 'ayu@example.test',
            'password' => 'service-secret',
            'password_confirmation' => 'service-secret',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', ['email' => 'ayu@example.test']);
        $this->assertAuthenticated();
    }

    public function test_registration_requires_matching_password_confirmation(): void
    {
        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Ayu Pratama',
                'email' => 'ayu@example.test',
                'password' => 'service-secret',
                'password_confirmation' => 'different-secret',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'ayu@example.test']);
    }
}

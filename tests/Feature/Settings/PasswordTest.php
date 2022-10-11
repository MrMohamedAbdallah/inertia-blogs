<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_allows_user_to_update_password()
    {
        // Arrange
        $user = User::factory()->create();
        $oldPassword = $user->password;

        // Act
        $this->actingAs($user);

        $this->get(route('settings'));

        $response = $this->followingRedirects()->post(route('settings.password'), [
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Settings/Index')
            );

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'password' => $oldPassword, // It should be updated
        ]);
    }


    public function test_the_password_must_be_confirmed()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $this->get(route('settings'));

        $response = $this->followingRedirects()->post(route('settings.password'), [
            'password' => 'new_password',
            'password_confirmation' => 'wrong_confirmation',
        ]);

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Settings/Index')
                    ->has('errors.password')
            );
    }
}

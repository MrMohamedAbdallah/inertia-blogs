<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_renders_current_user_data()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $response = $this->get(route('settings'));

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Settings/Index')
                    ->where('auth.user.email', $user->email)
                    ->where('auth.user.name', $user->name)
            );
    }


    public function test_it_allows_user_update_general_info()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $response = $this->post(route('settings.general'), [
            'name' => 'New name',
            'email' => 'new@example.com',
        ]);

        // Assert
        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New name',
            'email' => 'new@example.com',
        ]);
    }


    public function test_it_prevent_updated_already_used_emails()
    {
        // Arrange
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Act
        $this->actingAs($user);

        $this->get(route('settings'));

        $response = $this->followingRedirects()->post(route('settings.general'), [
            'name' => 'New name',
            'email' => $user2->email,
        ]);

        // Assert
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Settings/Index')
                ->has('errors.email')
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email, // Old email
        ]);
    }


    public function test_it_allows_user_to_update_profile_picture()
    {
        // Arrange
        $user = User::factory()->create();
        Storage::fake('public');
        $profilePicture = UploadedFile::fake()->image('profile.png');

        // Act
        $this->actingAs($user);

        $this->get(route('settings'));

        $response = $this->followingRedirects()->post(route('settings.general'), [
            'name' => 'New name',
            'email' => 'new@example.com',
            'profilePicture' => $profilePicture,
        ]);

        // Assert
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Settings/Index')
                ->has('errors', 0)
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New name',
            'email' => 'new@example.com',
            'profile_picture' => 'profiles/' . $profilePicture->hashName(),
        ]);
    }
}

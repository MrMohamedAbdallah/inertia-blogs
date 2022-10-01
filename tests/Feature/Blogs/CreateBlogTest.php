<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateBlogTest extends TestCase
{

    public function test_it_render_create_blog_page()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $response = $this->get(route('blogs.create'));

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Create')
            );
    }


    public function test_it_should_return_errors_when_required_fields_fail_validation()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $this->get(route('blogs.create'));

        $response = $this->followingRedirects()->post(route('blogs.store'));

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Create')
                    ->has('errors.title')
                    ->has('errors.body')
            );
    }


    public function test_it_allows_user_to_create_a_blog()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);

        $this->get(route('blogs.create'));

        $response = $this->followingRedirects()->post(route('blogs.store'), [
            'title' => 'Blog title',
            'body' => 'Blog body',
        ]);

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Dashboard')
                    ->has('blogs.data', 1)
                    ->where('blogs.data.0.title', 'Blog title')
            );

        $this->assertDatabaseHas('blogs', [
            'user_id' => auth()->id(),
            'title' => 'Blog title',
            'body' => 'Blog body',
            'cover' => null,
        ]);
    }


    public function test_it_allows_user_to_upload_cover_image()
    {
        // Arrange
        $user = User::factory()->create();
        Storage::fake('public');
        $cover = UploadedFile::fake()->image('cover.jpg');

        // Act
        $this->actingAs($user);

        $this->get(route('blogs.create'));

        $response = $this->followingRedirects()
            ->post(route('blogs.store'), [
                'title' => 'Blog title',
                'body' => 'Blog body',
                'cover' => $cover,
            ]);


        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Dashboard')
                    ->has('blogs.data', 1)
                    ->where('blogs.data.0.title', 'Blog title')
            );

        Storage::disk('public')->assertExists('covers/' . $cover->hashName());

        $this->assertDatabaseHas('blogs', [
            'user_id' => auth()->id(),
            'title' => 'Blog title',
            'body' => 'Blog body',
            'cover' => 'covers/' . $cover->hashName(),
        ]);
    }


    public function test_it_should_return_errors_when_the_cover_is_not_an_image()
    {
        // Arrange
        $user = User::factory()->create();
        Storage::fake('public');
        $cover = UploadedFile::fake()->image('cover.pdf');

        // Act
        $this->actingAs($user);

        $this->get(route('blogs.create'));

        $response = $this->followingRedirects()
            ->post(route('blogs.store'), [
                'title' => 'Blog title',
                'body' => 'Blog body',
                'cover' => $cover,
            ]);

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Create')
                    ->has('errors.cover')
            );


        Storage::disk('public')->assertMissing('covers/' . $cover->hashName());

        $this->assertDatabaseMissing('blogs', [
            'user_id' => auth()->id(),
            'title' => 'Blog title',
            'body' => 'Blog body',
            'cover' => 'covers/' . $cover->hashName(),
        ]);
    }
}

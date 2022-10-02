<?php

namespace Tests\Feature\Blogs;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class EditBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_edit_link_to_blog_owner()
    {
        // Arrange
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $response = $this->get(route('blogs.show', $blog));


        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Show')
                    ->where('blog.data.can.edit', true)
            );
    }


    public function test_it_does_not_show_link_to_other_users_or_guest()
    {
        // Arrange
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        // Act
        $response = $this->get(route('blogs.show', $blog));

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Show')
                    ->where('blog.data.can.edit', false)
            );
    }


    public function test_it_renders_edit_page_correctly()
    {
        // Arrange
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $response = $this->get(route('blogs.edit', $blog));

        // Assert
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Blogs/Edit')
                    ->where('blog.data.title', $blog->title)
                    ->where('blog.data.body', $blog->body)
                    ->where('blog.data.cover', $blog->cover)
            );
    }


    public function test_only_owner_can_visit_edit_page()
    {
        // Arrange
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user2);
        $response = $this->get(route('blogs.edit', $blog));

        // Assert
        $response->assertForbidden();
    }


    public function test_it_allow_blog_owner_to_edit_blog()
    {
        // Arrange 
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);
        Storage::fake('public');
        $cover = UploadedFile::fake()->image('cover.jpg');


        // Act
        $this->actingAs($user);

        $response = $this->put(route('blogs.update', $blog), [
            'title' => 'Updated title',
            'body' => 'Updated body',
            'cover' => $cover,
        ]);

        // Assert
        $response->assertRedirect(route('blogs.show', $blog));

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'title' => 'Updated title',
            'body' => 'Updated body',
        ]);
    }


    public function test_only_blog_owner_is_allowed_to_edit_it()
    {
        // Arrange 
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);
        Storage::fake('public');
        $cover = UploadedFile::fake()->image('cover.jpg');


        // Act
        $this->actingAs($user2);

        $response = $this->put(route('blogs.update', $blog), [
            'title' => 'Updated title',
            'body' => 'Updated body',
            'cover' => $cover,
        ]);

        // Assert
        $response->assertForbidden();

        $this->assertDatabaseMissing('blogs', [
            'id' => $blog->id,
            'title' => 'Updated title',
            'body' => 'Updated body',
        ]);
    }
}

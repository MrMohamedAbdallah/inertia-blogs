<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DeleteBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_delete_button_to_blog_owner()
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
                    ->where('blog.data.can.delete', true)
            );
    }


    public function test_it_does_not_show_delete_button_to_other_users()
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
                    ->where('blog.data.can.delete', false)
            );
    }


    public function test_user_can_delete_his_blog()
    {
        // Arrange
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $response = $this->delete(route('blogs.destroy', $blog));

        // Assert
        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseMissing('blogs', [
            'id' => $blog->id,
        ]);
    }
}

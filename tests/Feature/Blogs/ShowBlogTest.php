<?php

namespace Tests\Feature\Blogs;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowBlogTest extends TestCase
{
    public function test_it_shows_the_blog()
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
                    ->has('blog')
                    ->where('blog.data.title', $blog->title)
                    ->where('blog.data.body', $blog->body)
            );
    }
}

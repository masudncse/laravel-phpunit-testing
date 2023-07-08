<?php


namespace Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_index_page_is_displayed()
    {
        $this->checkAuthentication();

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
    }

    public function test_post_create_page_is_displayed()
    {
        $this->checkAuthentication();

        $response = $this->get(route('posts.create'));
        $response->assertStatus(200);
    }

    public function test_post_create_and_redirect_to_create_page()
    {
        $this->checkAuthentication();

        $response = $this->from(route('posts.create'))->post(route('posts.store'), [
            'title' => 'Title 1',
            'description' => 'Description 1',
        ]);

        $this->assertEquals(1, Post::count());

        $response->assertStatus(302);

        $response->assertRedirect(route('posts.create'));
    }

    public function test_post_delete_and_redirect_to_index_page()
    {
        $this->checkAuthentication();

        $response = $this->post(route('posts.store'), [
            'title' => 'Title 1',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(302);

        $post = Post::first();

        $response = $this->from(route('posts.index'))->delete(route('posts.destroy', $post->id));

        $this->assertEquals(0, Post::count());

        $response->assertStatus(302);

        $response->assertRedirect(route('posts.index'));
    }
}

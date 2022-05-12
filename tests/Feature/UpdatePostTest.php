<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    /** @test */
    public function error_to_access_update_page_without_post()
    {
        $this->post(route('posts.update', ['post']))->assertStatus(404);
    }

    /** @test */
    public function can_access_update_page()
    {
        $post = Post::factory()->create();
        $this->get(route('posts.update', ['post' => $post]))->assertSuccessful();
    }

    /** @test */
    public function post_has_been_updated()
    {
        Storage::fake('public');
        
        $post = Post::factory()->create();
        $this->assertNull($post->image_id);


        $this->post(route('posts.update', ['post' => $post]), ['title' => 'Bonsoir !', 'content' => 'Comment vous allez ?', 'published' => 1, 'picture' => UploadedFile::fake()->image('postimage.jpg')]);
        $post->refresh();

        $this->assertEquals($post->title, "Bonsoir !");
        $this->assertEquals($post->content, "Comment vous allez ?");
        $this->assertEquals($post->published, 1);

        $this->assertNotNull($post->image_id);

        $image = Image::first();
        $this->assertEquals($post->image_id, $image->getKey());
    }

}
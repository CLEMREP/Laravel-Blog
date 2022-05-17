<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorePostTest extends TestCase
{
    /** @test */
    public function can_store_post_in_database()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $this->assertDatabaseCount('images', 0);
        $this->assertDatabaseCount('posts', 0);


        $this->actingAs($user)->post(
            route('admin.posts.store'), 
            [
                'title' => 'Assert Test',
                'content' => 'Ceci est un test Assertion',
                'published' => 0,
                'picture' => UploadedFile::fake()->image('postimage.jpg')
            ]
        );
        
        
        $this->assertDatabaseCount('images', 1);
        $this->assertDatabaseCount('posts', 1);

        $post = Post::first();
        $this->assertNotNull($post->image_id);

        $image = Image::first();
        $this->assertEquals($post->image_id, $image->getKey());

        $this->assertTrue(Storage::disk('public')->exists($image->path));
    }
}

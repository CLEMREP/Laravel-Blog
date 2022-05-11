<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;

class IndexPostTest extends TestCase
{
    /** @test */
    public function can_access_index_post()
    {
        $this->get('/posts')->assertSuccessful();
    }

    /** @test */
    public function count_number_of_posts_between_array_and_database()
    {
        $posts = Post::factory()->count(3)->create();

        $reponse = $this->get('/posts');
        $data = $reponse->viewData("posts");

        $this->assertCount(3, $data);

        for($i=0; $i < sizeof($posts); $i++) {
            $this->assertSame($posts[$i]["id"], $data[$i]["id"]);
        }
    }
}

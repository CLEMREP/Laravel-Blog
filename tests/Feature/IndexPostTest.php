<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class IndexPostTest extends TestCase
{
    /** @test */
    public function can_access_index_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('posts.index'))->assertSuccessful();
    }

    /** @test */
    public function count_number_of_posts_between_array_and_database()
    {
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create();

        $reponse = $this->actingAs($user)->get(route('posts.index'));
        $data = $reponse->viewData("posts");

        $this->assertCount(3, $data);

        for($i=0; $i < sizeof($posts); $i++) {
            $this->assertSame($posts[$i]["id"], $data[$i]["id"]);
        }
    }
}

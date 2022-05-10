<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorePostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function can_store_post_in_database()
    {
        $this->assertDatabaseCount('posts', 0);
        $this->post('/posts/create', ['title' => 'Assert Test', 'content' => 'Ceci est un test Assertion']);
        $this->assertDatabaseCount('posts', 1);
    }
}

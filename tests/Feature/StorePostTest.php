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
    public function test_example()
    {
        $this->assertDatabaseCount('posts', 0);
        $this->post('/posts/create', ['title' => 'Assert Test', 'content' => 'Ceci est un test Assertion']);
        $this->assertDatabaseCount('posts', 1);
    }
}

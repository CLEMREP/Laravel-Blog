<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreatePostPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function can_access_post_create_form()
    {
        $this->get('/posts/create')->assertSuccessful();
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;


class WelcomePageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function can_access_welcome_page()
    {
        $this->get('/')->assertSuccessful();
    }
}

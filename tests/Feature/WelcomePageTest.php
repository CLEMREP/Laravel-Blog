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
    public function test_example()
    {
        $reponse = $this->get('/');

        $reponse->assertStatus(200);
    }
}

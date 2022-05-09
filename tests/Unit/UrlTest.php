<?php

namespace Tests\Unit;

use Tests\TestCase;


class UrlTest extends TestCase
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

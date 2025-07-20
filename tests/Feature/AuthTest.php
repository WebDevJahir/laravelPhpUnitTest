<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated_user_cannot_access_product(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(302); // Check for redirect status
        $response->assertRedirect('/login');
    }
}

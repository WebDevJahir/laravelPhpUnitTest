<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_to_products(): void
    {

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
    }


    public function test_paginated_products_table_doesnt_contain_11th_record(): void
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(11)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($user)->get('/products');
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }
}

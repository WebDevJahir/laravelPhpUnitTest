<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 
     * A basic feature test example.
     */
    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createAdmin(isadmin: 1);
    }

    public function test_homepage_has_data(): void
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertSee("No Data Found");
    }

    public function test_home_page_has_products(): void
    {
        Product::create(
            [
                'name' => "Test Product",
                'price' => 99.99
            ]
        );
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertDontSee("No Data Found");
    }

    public function test_admin_can_see_create_product_button(): void
    {
        $response = $this->actingAs($this->admin)->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Add New Product');
    }

    public function test_user_cannot_see_create_product_button(): void
    {
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
        $response->assertDontSee('Add New Product');
    }

    public function test_admin_can_access_product_create_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/products/create');
        $response->assertStatus(200);
    }

    public function test_user_cannot_access_product_create_page(): void
    {
        $response = $this->actingAs($this->user)->get('/products/create');
        $response->assertStatus(403); // Forbidden
    }

    public function test_product_created_successfully(): void
    {
        $product = [
            'name' => 'Test Product',
            'price' => 19.99,
        ];

        $response = $this->actingAs($this->admin)->post('/products/store', $product);
        $response->assertRedirect(route('products'));
        $response->assertSessionHas('success', 'Product created successfully.');

        $this->assertDatabaseHas('products', $product);

        $lastProduct = Product::latest()->first();
        $this->assertEquals($product['name'], $lastProduct->name);
        $this->assertEquals($product['price'], $lastProduct->price);
    }

    public function test_product_edit_page_loads_correctly(): void
    {
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('products.edit', $product->id));
        $response->assertStatus(200);
        $response->assertSee('value="' . $product->name . '"', false);
        $response->assertSee('value="' . $product->price . '"', false);
    }

    public function test_product_update_functionality(): void
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product',
            'price' => 100.00,
        ];

        $response = $this->actingAs($this->admin)->put(route('products.update', $product->id), $updatedData);
        $response->assertRedirect(route('products'));
        $response->assertSessionHas('success', 'Product updated successfully.');
    }

    public function test_check_validatetion_on_product_update(): void
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => '',
            'price' => -10.00,
        ];

        $response = $this->actingAs($this->admin)->from(route('products.edit', $product->id))
            ->put(route('products.update', $product->id), $updatedData);
        $response->assertRedirect(route('products.edit', $product->id));
        $response->assertSessionHasErrors(['name', 'price']);
    }

    public function test_product_deletion(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('products.destroy', $product->id));
        $response->assertRedirect(route('products'));
        $response->assertSessionHas('success', 'Product deleted successfully.');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createAdmin(int $isadmin = 1): User
    {
        return User::factory()->create(['is_admin' => $isadmin]);
    }
}

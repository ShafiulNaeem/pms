<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductTest extends TestCase
{
    //use RefreshDatabase;
    public function test_an_admin_can_create_product()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'api')->postJson('/api/admin/product/store', [
            'name' => 'test',
            'price' => 50.00,
            'stock' => 100,
        ]);
        $response->dump();
        $response->assertStatus(201);
    }
    public function test_a_regular_user_cannot_create_product()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/admin/product/store', [
            'name' => 'test',
            'price' => 50.00,
            'stock' => 100,
        ]);
        $response->dump();

        $response->assertStatus(401);
    }
    public function test_an_admin_can_update_product()
    {
        $admin = User::find(1);

        $response = $this->actingAs($admin, 'api')->putJson('/api/admin/product/update/1', [
            'name' => 'test',
            'price' => 50.00,
            'stock' => 100,
        ]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_an_admin_can_delete_product()
    {
        $admin = User::find(1);

        $response = $this->actingAs($admin, 'api')->deleteJson('/api/admin/product/delete/2');
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_an_admin_can_view_all_products()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin, 'api')->getJson('/api/admin/product/list?search=');
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_an_admin_can_view_a_product()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin, 'api')->getJson('/api/admin/product/show/1');
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_user_product_route()
    {
        $user = User::find(2);
        $response = $this->actingAs($user, 'api')->getJson('/api/products?search=');
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_an_admin_can_not__access_user_product_route()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin, 'api')->getJson('/api/products?search=');
        $response->dump();
        $response->assertStatus(401);
    }
}

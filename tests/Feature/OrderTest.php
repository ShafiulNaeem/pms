<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class OrderTest extends TestCase
{
    public function test_order_can_be_created()
    {
        $user = User::find(2);
        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'product_id' => 1,
            'quantity' => 2,
        ]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_order_stock()
    {
        $user = User::find(2);
        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'product_id' => 1,
            'quantity' => 200,
        ]);
        $response->dump();
        $response->assertStatus(422);
    }
    public function test_order_can_be_listed()
    {
        $user = User::find(2);
        $response = $this->actingAs($user, 'api')->getJson('/api/orders');
        $response->dump();
        $response->assertStatus(200);
    }
}

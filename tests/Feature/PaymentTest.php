<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PaymentTest extends TestCase
{
    public function test_payment_intialization()
    {
        $user = User::find(2);
        $response = $this->actingAs($user, 'api')->postJson('/api/pay', [
            'order_id' => 1
        ]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_payment_success()
    {
        $response = $this->get('/api/payment-success?order_id=1');
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_payment_failure()
    {
        $response = $this->get('/api/payment-failure');
        $response->dump();
        $response->assertStatus(200);
    }
}

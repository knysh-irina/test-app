<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_store_transaction_by_user(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/transactions', [
            'type' => Transaction::TYPE_DEBIT,
            'amount' => 111,
        ]);

        $response->assertStatus(201)->assertExactJson([
            'created' => true,
        ]);
    }

    /**
     * @return void
     */
    public function test_store_transaction_by_guest(): void
    {
        $response = $this->post('api/transactions', [
            'type' => Transaction::TYPE_DEBIT,
            'amount' => 111,
        ]);

        $response->assertStatus(302);
    }
}

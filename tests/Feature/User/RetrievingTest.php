<?php

namespace Tests\Feature\User;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class RetrievingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_get_latest_users_with_debit_sum(): void
    {
        $this->be(User::where('permissions', User::ROLE_ADMIN)->first());

        User::factory()
            ->has(Transaction::factory()->state(new Sequence(
                ['type' => Transaction::TYPE_DEBIT],
                ['type' => Transaction::TYPE_CREDIT],
            ))->count(100))
            ->count(10)
            ->create();

        $response = $this->get('api/users/latest');

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has(10)
            ->first(fn($json) => $json->has('transactions_sum_amount')
                ->missing('permissions')
                ->etc()
            )
        );
    }
}

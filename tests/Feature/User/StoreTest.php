<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_store_user_by_admin(): void
    {
        $this->be(User::where('permissions', User::ROLE_ADMIN)->first());

        $response = $this->post('api/users', [
            'name' => 'Sally',
            'email' => 'test@gmail.com',
        ]);

        $response->assertStatus(201)->assertExactJson([
            'created' => true,
        ]);
    }

    /**
     * @return void
     */
    public function test_store_user_by_quest(): void
    {
        $response = $this->post('api/users', [
            'name' => 'Sally',
            'email' => 'test@gmail.com',
        ]);

        $response->assertStatus(403);
    }

    /**
     * @return void
     */
    public function test_store_user_by_user(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/users', [
            'name' => 'Sally',
            'email' => 'test@gmail.com',
        ]);

        $response->assertStatus(403);
    }

    /**
     * @return void
     */
    public function test_store_user_duplicate_name(): void
    {
        $this->be(User::where('permissions', User::ROLE_ADMIN)->first());

        User::create([
            'name' => 'Sally',
            'email' => 'test@gmail.com',
        ]);

        $response = $this->post('api/users', [
            'name' => 'Sally',
            'email' => 'test@gmail.com',
        ]);

        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_store_user_invalid_email(): void
    {
        $this->be(User::where('permissions', User::ROLE_ADMIN)->first());

        $response = $this->post('api/users', [
            'name' => 'Sally',
            'email' => 'test123',
        ]);

        $response->assertStatus(302);
    }
}

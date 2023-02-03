<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_with_validated_credentials()
    {
        Notification::fake();
        $response = $this->post('/api/register',[
            "full_name"=>"Test User",
            "email"=>"test@gmail.com",
            "password"=>"password",
            "password_confirmation"=>"password"
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount("users",1);
        $this->assertDatabaseCount("shopping_sessions",1);
        $user = User::firstOrFail();
        Notification::assertSentTo($user, VerifyEmail::class);
        Notification::assertTimesSent(1, VerifyEmail::class);
    }
}

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
        $this->assertDatabaseCount("users",1)->assertDatabaseCount("shopping_sessions",1);
        $user = User::firstOrFail();
        Notification::assertSentTo($user, VerifyEmail::class);
        Notification::assertTimesSent(1, VerifyEmail::class);
    }

    public function test_register_with_non_validated_credentials()
    {
        Notification::fake();
        $response = $this->post('/api/register',[
            "full_name"=>"Test User",
            "email"=>"test@gmail.com",
            "password"=>"password",
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseCount("users",0)->assertDatabaseCount("shopping_sessions",0);
    }
/*
    public function test_login_with_validated_credentials()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/login',[
            "email"=>$user->email,
            "password"=>"password"
        ]);

        $response->assertJson(["is_error"=>false])->assertStatus(Response::HTTP_OK);
    }*/

    public function test_login_with_user_who_doesnt_exists()
    {
        $response = $this->post('/api/login',[
            "email"=>"test@gmail.com",
            "password"=>"password",
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_login_with_non_validated_credentials()
    {
        $user = User::factory()->create([
            "full_name"=>"Test User",
            "email"=>"test@gmail.com",
        ]);
        $response = $this->post('/api/login',[
            "email"=>"test1@gmail.com",
            "password"=>"password",
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_resend_verification_email()
    {
        Notification::fake();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post("/api/email/verify/resend");
        $response->assertStatus(Response::HTTP_OK);
        Notification::assertSentTo($user, VerifyEmail::class);
        Notification::assertTimesSent(1, VerifyEmail::class);
    }

}

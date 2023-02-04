<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_address()
    {
        $response = $this->actingAs(User::factory()->create())->get('/api/address');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_address()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post("/api/address",[
            "name"=> fake()->name,
            "city"=>fake()->city,
            "address"=>fake()->address,
            "receiver_full_name"=>fake()->name,
        ]);
        $this->assertDatabaseCount("addresses",1);
        $response->assertStatus(Response::HTTP_CREATED)->assertJson(["is_error"=>false]);
    }

    public function test_create_address_with_non_validated_form()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post("/api/address",[
            "name"=> fake()->name,
            "city"=>fake()->city,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson(["is_error"=>true]);
    }

    public function test_edit_address()
    {
        $this->actingAs(User::factory()->create());
        $address = Address::factory()->create();
        $response = $this->get("/api/address/".$address->id."/edit");
        $response->assertStatus(Response::HTTP_OK)->assertJson(["is_error"=>false]);
    }

    public function test_update_address()
    {
        $this->actingAs(User::factory()->create());
        $address = Address::factory()->create();
        $new_name = fake()->name;
        $response = $this->put("/api/address/".$address->id,[
            "name" => $new_name,
            "city"=>fake()->city,
            "address"=>fake()->address,
            "receiver_full_name"=>fake()->name,
        ]);
        $this->assertDatabaseHas("addresses",["name"=>$new_name]);
        $response->assertStatus(Response::HTTP_CREATED)->assertJson(["is_error"=>false]);
    }

    public function test_update_address_with_missing_fields()
    {
        $this->actingAs(User::factory()->create());
        $address = Address::factory()->create();
        $response = $this->putJson("/api/address/".$address->id,[
            "name"=>"changed",
            "city"=>fake()->city,
            "address"=>fake()->address,
        ]);
        $this->assertDatabaseMissing("addresses",["name"=>"changed"]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson(["is_error"=>true]);
    }

    public function test_update_address_with_already_exist_field()
    {
        $this->actingAs(User::factory()->create());
        Address::factory()->create([
            "name"=>"Test 1"
        ]);
        $address = Address::factory()->create();
        $response = $this->putJson("/api/address/".$address->id,[
            "name"=>"Test 1",
            "city"=>fake()->city,
            "address"=>fake()->address,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson(["is_error"=>true]);
    }

    public function test_delete_address()
    {
        $this->actingAs(User::factory()->create());
        $address = Address::factory()->create();
        $response = $this->delete("/api/address/".$address->id);
        $this->assertSoftDeleted("addresses");
        $response->assertStatus(Response::HTTP_OK)->assertJson(["is_error"=>false]);
    }

    public function test_delete_address_already_deleted()
    {
        $this->actingAs(User::factory()->create());
        $address = Address::factory()->create([
            "deleted_at" => Date::now()
        ]);
        $response = $this->delete("/api/address/".$address->id);
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson(["is_error"=>true]);
    }
}

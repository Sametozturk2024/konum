<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LocationsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user, ['*']);
    }

    /** @test */
    public function user_can_list_locations()
    {
        Location::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function user_can_store_location()
    {
        $payload = [
            'name'         => 'Test Location',
            'latitude'     => 41.0,
            'longitude'    => 29.0,
            'marker_color' => '#ff0000',
            'description'  => 'Test açıklaması',
            'orders'       => 1,
        ];

        $response = $this->postJson('/api/locations', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'location' => ['id', 'name']]);

        $this->assertDatabaseHas('locations', [
            'name'     => 'Test Location',
            'user_id'  => $this->user->id,
        ]);
    }

    /** @test */
    public function user_can_view_specific_location()
    {
        $location = Location::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/locations/{$location->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $location->id]);
    }

    /** @test */
    public function user_can_update_location()
    {
        $location = Location::factory()->create(['user_id' => $this->user->id]);

        $payload = [
            'name'         => 'Updated Name',
            'latitude'     => 40.1,
            'longitude'    => 30.1,
            'marker_color' => '#000000',
            'description'  => 'Updated description',
            'orders'       => 2,
        ];

        $response = $this->putJson("/api/locations/{$location->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('locations', [
            'id'   => $location->id,
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function user_can_delete_location()
    {
        $location = Location::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/locations/{$location->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Konum başarıyla silindi']);

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    /** @test */
    public function user_can_use_map_distance_endpoint()
    {
        Location::factory()->create([
            'user_id'     => $this->user->id,
            'name'        => 'A',
            'latitude'    => 41.1,
            'longitude'   => 29.1,
            'marker_color'=> '#ff0000',
        ]);

        $payload = [
            'latitude'  => 41.0,
            'longitude' => 29.0,
        ];

        $response = $this->postJson('/api/locations/maps', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['name', 'marker_color', 'km']]]);
    }
}

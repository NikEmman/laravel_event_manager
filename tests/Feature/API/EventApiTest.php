<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_only_future_events_in_v1_format()
    {
        $space = Space::create(['name' => 'Tech Center', 'address' => '123 Road']);

        // Create one future event
        Event::create([
            'title' => 'Future Event',
            'space_id' => $space->id,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        // Create one past event
        Event::create([
            'title' => 'Past Event',
            'space_id' => $space->id,
            'start_date' => now()->subDay(),
            'end_date' => now()->subDay()->addHour(),
        ]);

        $response = $this->getJson('/api/v1/events');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data') // Only the future one
            ->assertJsonPath('data.0.title', 'Future Event');
    }
}
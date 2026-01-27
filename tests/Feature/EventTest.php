<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Space;
use App\Models\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class EventTest extends TestCase
{
    use RefreshDatabase;


    public function test_the_new_event_page_displays_spaces()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Grand Ballroom', 'address' => '123 Street']);

        $response = $this->actingAs($user)->get('/events/new');

        $response->assertStatus(200);
        $response->assertSee('Grand Ballroom');
    }
    public function test_a_guest_cannot_create_an_event()
    {
        // Create a Space (required for the foreign key)
        $space = Space::create(['name' => 'Secret Room', 'address' => 'Unknown']);

        // Attempt to post data without calling actingAs()
        $response = $this->post('/events/create', [
            'title' => 'Sneaky Event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(2)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);


        // Expect redirect because the POST method is not allowed for guests at this URL
        $response->assertRedirect('/login');

        // Check that the database is still empty
        $this->assertCount(0, Event::all());
    }


    public function test_a_guest_cannot_see_the_new_event_form()
    {
        $response = $this->get('/events/new');

        // This ensures the user is redirected to the login page
        $response->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_an_event()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Gallery', 'address' => '456 Ave']);

        $eventData = [
            'title' => 'Art Show',
            'description' => 'A cool event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(2)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(3)->format('Y-m-d H:i'),
        ];

        $response = $this->actingAs($user)->post('/events/create', $eventData);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('events', ['title' => 'Art Show']);
    }


    public function test_an_event_cannot_start_in_the_past()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Gallery', 'address' => '456 Ave']);

        $response = $this->actingAs($user)->from('/events/new')->post('/events/create', [
            'title' => 'Old Event',
            'space_id' => $space->id,
            'start_date' => now()->subDays(5)->format('Y-m-d H:i'), // 5 days ago
            'end_date' => now()->addDays(1)->format('Y-m-d H:i'),
        ]);

        $response->assertSessionHasErrors(['start_date']);
    }


    public function test_end_date_must_be_after_start_date()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Gallery', 'address' => '456 Ave']);

        $response = $this->actingAs($user)->from('/events/new')->post('/events/create', [
            'title' => 'Time Travel Event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(5)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(2)->format('Y-m-d H:i'), // Ends BEFORE it starts
        ]);

        $response->assertSessionHasErrors(['end_date']);
    }
    // Show route

    public function test_anyone_can_view_a_single_event()
    {
        $space = Space::create(['name' => 'The Hub', 'address' => 'Main St 1']);
        $event = Event::create([
            'title' => 'Public Talk',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1)->addHours(2),
        ]);

        $response = $this->get("/events/{$event->id}");

        $response->assertStatus(200);
        $response->assertSee('Public Talk');
        $response->assertSee('Main St 1');
    }
    // Delete route / action
    public function test_an_authenticated_user_can_delete_an_event()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Test Space', 'address' => 'Test Ave']);
        $event = Event::create([
            'title' => 'Delete Me',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1)->addHour(),
        ]);

        $response = $this->actingAs($user)->delete("/events/{$event->id}");

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_a_guest_cannot_delete_an_event()
    {
        $space = Space::create(['name' => 'Test Space', 'address' => 'Test Ave']);
        $event = Event::create([
            'title' => 'Unsafe Event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1)->addHour(),
        ]);

        $response = $this->delete("/events/{$event->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }
}

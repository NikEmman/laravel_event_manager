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

    // Create event action
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
    // Edit route tests
    public function test_an_authenticated_user_can_see_the_edit_page()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Original Space', 'address' => '123 Lane']);

        $event = Event::create([
            'title' => 'Initial Title',
            'description' => 'Initial Description',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1)->addHours(2),
        ]);

        $response = $this->actingAs($user)->get("/events/{$event->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Initial Title');
        $response->assertSee('Initial Description');
        $response->assertSee('Original Space');
    }
    public function test_a_guest_cannot_see_the_edit_page()
    {
        $space = Space::create(['name' => 'Private Room', 'address' => 'Secret']);
        $event = Event::create([
            'title' => 'Secret Event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1)->addHours(1),
        ]);

        $response = $this->get("/events/{$event->id}/edit");

        $response->assertRedirect('/login');
    }

    // Put action and route tests
    public function test_an_authenticated_user_can_update_an_event()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Initial Space', 'address' => '123 Lane']);

        // Create the existing event
        $event = Event::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(1)->addHours(2)->format('Y-m-d H:i'),
        ]);

        // Data to update
        $updatedData = [
            'title' => 'New Improved Title',
            'description' => 'Updated Description',
            'space_id' => $space->id,
            'start_date' => now()->addDays(2)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(2)->addHours(2)->format('Y-m-d H:i'),
        ];

        // Sent put request as auth'ed user
        $response = $this->actingAs($user)->put("/events/{$event->id}", $updatedData);


        $response->assertRedirect("/events/{$event->id}");
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'New Improved Title'
        ]);
    }

    public function test_a_guest_cannot_update_an_event()
    {
        $space = Space::create(['name' => 'Space', 'address' => 'Addr']);
        $event = Event::create([
            'title' => 'Stable Title',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(1)->addHours(1)->format('Y-m-d H:i'),
        ]);

        // Try to update as guest
        $response = $this->put("/events/{$event->id}", ['title' => 'Hacked Title']);

        $response->assertRedirect('/login');
        // Ensure the title is still the original in the DB
        $this->assertDatabaseHas('events', ['title' => 'Stable Title']);
    }

    public function test_update_validation_errors_redirect_back_to_edit_form()
    {
        $user = User::factory()->create();
        $space = Space::create(['name' => 'Space', 'address' => 'Addr']);
        $event = Event::create([
            'title' => 'Valid Event',
            'space_id' => $space->id,
            'start_date' => now()->addDays(1)->format('Y-m-d H:i'),
            'end_date' => now()->addDays(1)->addHours(1)->format('Y-m-d H:i'),
        ]);

        // Send invalid data (end date before start date)
        $response = $this->actingAs($user)
            ->from("/events/{$event->id}/edit")
            ->put("/events/{$event->id}", [
                'title' => '', // Required field missing
                'space_id' => $space->id,
                'start_date' => now()->addDays(5)->format('Y-m-d H:i'),
                'end_date' => now()->addDays(2)->format('Y-m-d H:i'),
            ]);

        $response->assertRedirect("/events/{$event->id}/edit");
        $response->assertSessionHasErrors(['title', 'end_date']);
    }
}

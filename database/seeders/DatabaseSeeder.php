<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Space;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Spaces
        $ballroom = Space::create([
            'name' => 'Grand Ballroom',
            'address' => '123 Luxury Way, Downtown'
        ]);

        $techHub = Space::create([
            'name' => 'Tech Hub Meeting Room',
            'address' => '456 Innovation Drive'
        ]);

        $garden = Space::create([
            'name' => 'The Garden Terrace',
            'address' => '789 Park Avenue'
        ]);

        Event::create([
            'title' => 'Laravel Meetup',
            'description' => 'A gathering for PHP enthusiasts to talk about Eloquent and Blade.',
            'space_id' => $techHub->id,
            'start_date' => now()->addDays(7)->setTime(18, 00),
            'end_date' => now()->addDays(7)->setTime(21, 00),
        ]);

        Event::create([
            'title' => 'Annual Charity Gala',
            'description' => 'A black-tie event to raise funds for local libraries.',
            'space_id' => $ballroom->id,
            'start_date' => now()->addDays(14)->setTime(19, 00),
            'end_date' => now()->addDays(15)->setTime(00, 00),
        ]);

        Event::create([
            'title' => 'Coding Bootcamp Workshop',
            'description' => 'Intensive session on building CRUD apps.',
            'space_id' => $garden->id,
            'start_date' => now()->addDays(2)->setTime(9, 00),
            'end_date' => now()->addDays(2)->setTime(17, 00),
        ]);
    }

}

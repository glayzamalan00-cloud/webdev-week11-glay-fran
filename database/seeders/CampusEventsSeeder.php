<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class CampusEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $v = [
            Venue::create(['name' => 'Main Auditorium', 'address' => 'Building A', 'capacity' => 300]),
            Venue::create(['name' => 'Innovation Lab',  'address' => 'Building B', 'capacity' => 50]),
            Venue::create(['name' => 'Open Quad',       'address' => 'Campus Grounds', 'capacity' => 500]),
        ];

        $e = [
            Event::create(['venue_id' => $v[0]->id, 'title' => 'Orientation Day',   'event_date' => '2026-12-01']),
            Event::create(['venue_id' => $v[0]->id, 'title' => 'Tech Talk',         'event_date' => '2026-12-03']),
            Event::create(['venue_id' => $v[1]->id, 'title' => 'Hackathon',         'event_date' => '2026-12-05']),
            Event::create(['venue_id' => $v[1]->id, 'title' => 'Robotics Workshop', 'event_date' => '2026-12-08']),
            Event::create(['venue_id' => $v[2]->id, 'title' => 'Sports Fest',       'event_date' => '2026-12-10']),
            Event::create(['venue_id' => $v[2]->id, 'title' => 'Music Night',       'event_date' => '2026-12-12']),
        ];

        $p = [];
        foreach (['Ana', 'Ben', 'Cara', 'Dan', 'Eli', 'Fay', 'Gio', 'Hana'] as $n) {
            $p[] = Participant::create(['name' => $n, 'email' => strtolower($n).'@campus.edu']);
        }

        $e[0]->participants()->attach([
            $p[0]->id => ['status' => 'registered'],
            $p[1]->id => ['status' => 'registered'],
            $p[2]->id => ['status' => 'waitlisted'],
        ]);
        $e[1]->participants()->attach([
            $p[0]->id => ['status' => 'registered'],
            $p[3]->id => ['status' => 'registered'],
        ]);
        $e[2]->participants()->attach([
            $p[1]->id => ['status' => 'registered'],
            $p[4]->id => ['status' => 'waitlisted'],
        ]);
        $e[3]->participants()->attach([
            $p[2]->id => ['status' => 'registered'],
            $p[5]->id => ['status' => 'registered'],
        ]);
        $e[4]->participants()->attach([
            $p[6]->id => ['status' => 'registered'],
            $p[7]->id => ['status' => 'waitlisted'],
        ]);
        $e[5]->participants()->attach([$p[7]->id => ['status' => 'registered']]);

        $e[0]->notes()->create(['body' => 'Bring student ID.']);
        $e[2]->notes()->create(['body' => 'Teams of 4 max.']);
        $e[4]->notes()->create(['body' => 'Weather backup: gym.']);
        $v[0]->notes()->create(['body' => 'Projector needs repair.']);
        $v[1]->notes()->create(['body' => 'Aircon works best in the morning.']);
        $v[2]->notes()->create(['body' => 'Requires permit for sound system.']);
    }
}

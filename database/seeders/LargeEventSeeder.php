<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LargeEventSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        $now = now();

        // 20 bagong venues
        $venues = [];
        for ($i = 1; $i <= 20; $i++) {
            $venues[] = [
                'name' => "Bulk Venue $i",
                'address' => "$i Campus Road, Calauan, Laguna",
                'capacity' => rand(50, 1000),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('venues')->insert($venues);
        $venueIds = DB::table('venues')->pluck('id')->all();

        // 250 participants, in chunks
        foreach (array_chunk(range(1, 250), 100) as $chunk) {
            $rows = [];
            foreach ($chunk as $n) {
                $rows[] = [
                    'name' => fake()->name(),
                    'email' => "bulk{$n}@example.com",
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('participants')->insert($rows);
        }
        $participantIds = DB::table('participants')->pluck('id')->all();

        // 20,000 events, in chunks of 1000
        $kinds = ['workshop', 'seminar', 'tournament', 'exhibit', 'bootcamp', 'job fair', 'training', 'talk'];
        $audiences = ['for all year levels', 'for IT students', 'for first-year students', 'for student leaders', 'for the whole community'];
        $notes = ['Registration is required.', 'Free snacks for attendees.', 'Bring your school ID.', 'Certificates will be given.', 'Slots are limited.'];
        $dressCodes = ['casual', 'formal', 'smart casual', 'uniform'];
        $allTags = ['music', 'sports', 'academic', 'career', 'art', 'tech', 'charity'];

        foreach (array_chunk(range(0, 19999), 1000) as $chunk) {
            $rows = [];
            foreach ($chunk as $i) {
                $description = ucfirst(fake()->randomElement($kinds)) . ' '
                    . fake()->randomElement($audiences) . '. '
                    . fake()->randomElement($notes);

                if ($i % 250 === 0) {
                    $description .= ' Includes a lantern parade.'; // 80 events = 0.4%
                }

                $dressCode = ($i % 200 === 0)
                    ? 'costume'                                  // 100 events = 0.5%
                    : fake()->randomElement($dressCodes);

                $start = fake()->dateTimeBetween('-6 months', '+6 months');

                $rows[] = [
                    'venue_id' => fake()->randomElement($venueIds),
                    'title' => 'Campus Event ' . ($i + 1),
                    'event_date' => $start->format('Y-m-d'),
                    'starts_at' => $start->format('Y-m-d H:i:s'),
                    'description' => $description,
                    'details' => json_encode([
                        'dress_code' => $dressCode,
                        'capacity' => rand(30, 500),
                        'tags' => fake()->randomElements($allTags, rand(1, 3)),
                    ]),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('events')->insert($rows);
        }

        // Registrations para sa unang 100 events (event_participant)
        $firstEventIds = DB::table('events')
        ->where(function ($q) {
             $q->where('id', '<=', 100)->orWhereRaw('id % 5 = 0');
           })
            ->pluck('id');
            foreach ($firstEventIds as $eventId) {
            $rows = [];
            foreach (fake()->randomElements($participantIds, rand(5, 30)) as $pid) {
                $rows[] = [
                    'event_id' => $eventId,
                    'participant_id' => $pid,
                    'status' => fake()->randomElement(['registered', 'registered', 'waitlisted']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
           DB::table('event_participant')->insertOrIgnore($rows);
        }
    }
}
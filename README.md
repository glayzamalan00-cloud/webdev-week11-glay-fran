# Week 10: Campus Events (Laravel + PostgreSQL)

## Setup

1. `composer install`
2. `cp .env.example .env` and set PostgreSQL credentials
3. `php artisan key:generate`
4. `php artisan migrate:fresh --seed`
5. `php artisan serve` → visit `/report`

## Relationship Table

| Link                | Type                    | FK Held By                                             | Methods                                                | ON DELETE        | Reason                                                        |
| ------------------- | ----------------------- | ------------------------------------------------------ | ------------------------------------------------------ | ---------------- | ------------------------------------------------------------- |
| Venue ↔ Event       | One-to-many             | `events.venue_id`                                      | `Venue::events()`, `Event::venue()`                    | RESTRICT         | A venue that still has events must not be deletable           |
| Event ↔ Participant | Many-to-many            | `event_participant.event_id`, `.participant_id`        | `Event::participants()`, `Participant::events()`       | CASCADE          | Deleting an event or participant removes their registrations  |
| Note ↔ Event/Venue  | Polymorphic one-to-many | `notes.noteable_id` + `noteable_type` (no DB-level FK) | `Event::notes()`, `Venue::notes()`, `Note::noteable()` | None (app-level) | One FK can't reference two tables, so code must keep it valid |

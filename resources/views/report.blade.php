<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Events Report</title>
    <style>
        :root {
            --bg: #f3f5f9;
            --card: #ffffff;
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --brand: #4f46e5;
            --brand-dark: #3730a3;
            --green-bg: #dcfce7;
            --green: #166534;
            --amber-bg: #fef3c7;
            --amber: #92400e;
            --blue-bg: #dbeafe;
            --blue: #1e40af;
            --pink-bg: #fce7f3;
            --pink: #9d174d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.5;
        }

        /* Header */
        .hero {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            padding: 28px 24px 70px;
        }

        .hero h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .hero p {
            margin: 4px 0 0;
            opacity: .85;
        }

        .wrap {
            max-width: 1000px;
            margin: -48px auto 40px;
            padding: 0 16px;
        }

        /* Filter bar */
        .filters {
            background: var(--card);
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: flex-end;
            margin-bottom: 24px;
        }

        .filters label {
            display: flex;
            flex-direction: column;
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
            gap: 4px;
        }

        .filters select {
            padding: 8px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-size: .95rem;
            min-width: 170px;
            background: #fff;
        }

        .filters button {
            background: var(--brand);
            color: #fff;
            border: 0;
            border-radius: 8px;
            padding: 10px 22px;
            font-weight: 600;
            cursor: pointer;
        }

        .filters button:hover {
            background: var(--brand-dark);
        }

        /* Query cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(440px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .card.full {
            grid-column: 1 / -1;
        }

        .card h2 {
            margin: 0;
            padding: 14px 20px;
            font-size: 1rem;
            background: #eef2ff;
            color: var(--brand-dark);
            border-bottom: 1px solid var(--line);
        }

        .card h2 span {
            color: var(--ink);
            font-weight: 500;
        }

        .card ul {
            list-style: none;
            margin: 0;
            padding: 6px 20px 12px;
        }

        .card li {
            padding: 9px 0;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
        }

        .card li:last-child {
            border-bottom: 0;
        }

        .muted {
            color: var(--muted);
            font-size: .9rem;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .registered {
            background: var(--green-bg);
            color: var(--green);
        }

        .waitlisted {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .count {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .type-event {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .type-venue {
            background: var(--pink-bg);
            color: var(--pink);
        }

        footer {
            text-align: center;
            color: var(--muted);
            font-size: .85rem;
            padding-bottom: 24px;
        }

        @media (max-width: 520px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="hero">
        <h1>Campus Events Report</h1>
        <p>Relational data model: venues, events, participants and notes (Laravel + PostgreSQL)</p>
    </div>

    <div class="wrap">

        <form method="GET" class="filters">
            <label>Venue
                <select name="venue">
                    @foreach ($venues as $v)
                        <option value="{{ $v->id }}" @selected($v->id == $chosenVenue->id)>{{ $v->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>Event
                <select name="event">
                    @foreach ($allEvents as $e)
                        <option value="{{ $e->id }}" @selected($e->id == $chosenEvent->id)>{{ $e->title }}</option>
                    @endforeach
                </select>
            </label>
            <label>Participant
                <select name="participant">
                    @foreach ($allPeople as $p)
                        <option value="{{ $p->id }}" @selected($p->id == $chosenPerson->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit">Apply</button>
        </form>

        <div class="grid">

            <div class="card">
                <h2>Query 1: Every venue with number of events</h2>
                <ul>
                    @foreach ($venues as $v)
                        <li>{{ $v->name }} <span class="badge count">{{ $v->events_count }} events</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2>Query 2: All events at <span>{{ $chosenVenue->name }}</span></h2>
                <ul>
                    @foreach ($chosenVenue->events as $e)
                        <li>{{ $e->title }} <span class="muted">{{ $e->event_date->format('M d, Y') }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2>Query 3: Participants of <span>"{{ $chosenEvent->title }}"</span> with status</h2>
                <ul>
                    @foreach ($chosenEvent->participants as $p)
                        <li>{{ $p->name }} <span
                                class="badge {{ $p->pivot->status }}">{{ $p->pivot->status }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2>Query 4: Events joined by <span>{{ $chosenPerson->name }}</span></h2>
                <ul>
                    @foreach ($chosenPerson->events as $e)
                        <li>{{ $e->title }} <span
                                class="badge {{ $e->pivot->status }}">{{ $e->pivot->status }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2>Query 5: Events with at least one waitlisted participant</h2>
                <ul>
                    @foreach ($waitlistedEvents as $e)
                        <li>{{ $e->title }} <span class="badge waitlisted">has waitlist</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2>Query 6a: Notes of event <span>"{{ $chosenEvent->title }}"</span></h2>
                <ul>
                    @forelse($chosenEvent->notes as $n)
                        <li>{{ $n->body }}</li>
                    @empty
                        <li class="muted">No notes</li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
                <h2>Query 6b: Notes of venue <span>"{{ $chosenVenue->name }}"</span></h2>
                <ul>
                    @forelse($chosenVenue->notes as $n)
                        <li>{{ $n->body }}</li>
                    @empty
                        <li class="muted">No notes</li>
                    @endforelse
                </ul>
            </div>

            <div class="card full">
                <h2>Query 7: Every note and what it belongs to</h2>
                <ul>
                    @foreach ($notes as $n)
                        <li>
                            <span>"{{ $n->body }}"</span>
                            <span>
                                <span
                                    class="badge type-{{ strtolower($n->subject_type) }}">{{ $n->subject_type }}</span>
                                {{ $n->subject_name }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <footer>Campus Events: Week 10 Relational Data Model &amp; Queries</footer>

</body>

</html>

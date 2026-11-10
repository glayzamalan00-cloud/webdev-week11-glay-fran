# Week 11 - Optimized & Advanced Queries (Campus Events at Scale)

## Step 4: Query counts
| Version | Route | Queries sent |
|---|---|---|
| Naive (lazy loading) | \events\naive | 101 |
| Fixed (eager loading + withCount) | \events | 2 |

Explanation: The naive version sent 101 queries because it ran one query for the 50 events, then one more per event for its venue and one more per event for its participants. The fixed version sent 2 queries because `with('venue')` loads all the venues at once and `withCount('participants')` adds the count inside the main events query.

Note: `naive.blade.php` intentionally uses lazy loading to demonstrate the N+1 problem. The fixed page (`index.blade.php` and `_table.blade.php`) has no query logic.

## Step 7: Query plans
Rare values used: the word `lantern` (80 of 20,006 events, about 0.4%) and `dress_code = costume` (100 of 20,006 events, about 0.5%).

| Query | Index that exists | Plan type | Execution time |
|---|---|---|---|
| Q1 arrow `details->>'dress_code'` | none | Seq Scan | 13.910 ms |
| Q2 containment `details @> ...` | none | Seq Scan | 13.070 ms |
| Q3 full-text `lantern` | none | Seq Scan | 705.033 ms |
| Q1 arrow | events_dress_code_idx (btree on expression) | Bitmap Index Scan | 21.278 ms |
| Q2 containment | events_details_gin (GIN, jsonb_path_ops) | Bitmap Index Scan | 17.600 ms |
| Q3 full-text | events_description_fulltext (GIN on to_tsvector) | Bitmap Index Scan | 0.198 ms |
| Q1 arrow | events_details_gin only (index exists but unused) | Seq Scan | 15.904 ms |

Why the index was not used: The GIN index on `details` exists but Q1 did not use it, because a GIN index with `jsonb_path_ops` only helps containment operators like `@>`, while Q1 uses `->>` with `=`, which needs a btree index on that exact expression.

Observation: The full-text query improved a lot (705.033 ms to 0.198 ms). The two JSONB queries changed from Seq Scan to Bitmap Index Scan, and their estimated cost dropped, but their execution time did not improve. The table is small (about 20,000 rows) and fits in memory, so a sequential scan is already fast, and the first run with a new index may be slower because the index is not cached yet.

## Step 8: Indexes in migrations
All indexes are in the migration `add_indexes_to_events_table`, so they survive `php artisan migrate:fresh --seed`. The full-text index uses `$table->fullText('description')`. The GIN index on `details` and the expression index on `details->>'dress_code'` use raw `DB::statement()` because Laravel's schema builder has no method for them.

## Step 9: Choosing columns
- JSONB (`details`): the dress code (also capacity and tags). Each event can have different extra information, and a new key can be added without a new migration.
- Normal column (`starts_at`): the event's start date and time. It is used for sorting and filtering on every list, so it needs a proper date\time type.

## Scopes in Event model
| Scope | What it does |
|---|---|
| upcoming() | Events with starts_at from now onwards |
| earliestFirst() | Orders events by starts_at |
| dressCode($code) | Events whose details dress_code equals $code |
| search($term) | Full-text search on description |
| forList() | Eager loads venue and adds participants_count |





Chained example from index(): Event::upcoming()->earliestFirst()->forList()->limit(50)->get().

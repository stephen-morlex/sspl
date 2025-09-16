GOAL
Build a production-ready "live match" feature like https://www.livescore.com/... that shows an active match scoreboard, minute-by-minute timeline (goals, cards, subs, corners, VAR), lineups, team & player stats, match commentary and instant real-time updates when an admin enters a new event manually.

- Laravel version: <LARAVEL_VERSION, e.g. 12>
- Admin: Filament Admin v4
- Frontend: Laravel Livewire (Blade + Livewire components)
- Broadcasting: Laravel Echo with <PUSHER | LARAVEL_REVERB | BEYONDCODE> (choose default: Reverb)
- Queue: Redis + Laravel Queue (or Horizon)
- DB: sqlite
- Existing & functioning models (DO NOT recreate): Team, Player, Fixture (matches), League, Standing
- Existing match_events table: <yes|no> — if no, create it (see Migrations section)

GOAL
Create a production-ready **live match** subsystem (admin CRUD in Filament, Livewire frontend pages/components, broadcasting, match_event model/migration if missing, stats subsystem and idempotent UpdateStatsJob) that behaves like a live scoreboard/timeline (goals, cards, subs, corners, VAR, etc.). **Do not** implement API endpoints — admin will create events via Filament and spectators will view pages powered by Livewire + Echo.

REQUIREMENTS & DELIVERABLES
HIGH-LEVEL DELIVERABLES
1. DB migrations & Eloquent models for match events, player/team/per-match stats, and any supporting tables.
2. Broadcasting: Laravel Event classes + ShouldBroadcast implementations that publish to a per-match channel `match.{id}`. Frontend subscribes via Echo and updates UI instantly.
3. Livewire UI components and Blade views implementing:
   - Scoreboard header (team logos, name, score, current minute/status)
   - Live timeline (scrollable, newest on top or bottom)
   - Live commentary feed with event icons and pitch position thumbnails
   - Tabs: Lineups, Match Stats, Commentary, H2H
   - Mobile-first responsive layout
4. Admin Filament CRUD for creating/editing events and starting/stopping matches (with prevention of duplicate event processing).
5. Queued job (UpdateStatsJob) + listener that updates per-match & aggregated stats idempotently when events are created.

6) Database & migrations
- If `match_events` doesn't exist, create migration for `match_events` with fields:
  - id, match_id (foreign to `fixtures`), team_id (nullable), player_id (nullable), event_type (enum), minute (int), period (enum: 1H|HT|2H|ET|FT|PENALTIES), details JSON, pitch_position JSON (x,y nullable), updated_score JSON {home,away}, source, created_by, processed_at (nullable), created_at, updated_at.
- Migrations for statistics tables (if not present): `player_match_stats`, `team_match_stats`, `player_stats`, `team_stats` (use schemas from previous spec). Use `2025_09_11_000000_` prefix in class names for easy replacement.
- Provide indexes for quick queries: e.g., `match_events(match_id)`, `(match_id, minute)`, `player_match_stats(match_id, player_id)`, `team_match_stats(match_id, team_id)`.

1) Eloquent models & relationships (files)
- `MatchEvent` model (if missing): $fillable, $casts (details, pitch_position, updated_score), relations to Fixture, Team, Player.
- `PlayerMatchStat`, `TeamMatchStat`, `PlayerStat`, `TeamStat` models (with $fillable, $casts, relations).

**Note:** Do NOT recreate Team, Player, Fixture, League, Standing — instead, reference them.

3) Filament admin
- Filament Resource(s) / Pages to:
  - Create & edit `match_events` with validation and player↔team membership check (prevent selecting a player who does not belong to the selected team; if player.team_id missing, show warning but allow admin override with confirmation).
  - Quick admin scoreboard controls (start/pause/resume match, set kickoff time, set status: LIVE, HT, FT, SUSPENDED).
  - Match Event modal in Filament for fast entry (preselect common event templates: goal, sub, yellow/red, corner, offside, penalty_missed, VAR_review) with sensible defaults.
  - Filament list view with filters (match, team, minute range, event_type) and ability to re-run stats processing for an event (button to reprocess).
- Implement server-side validation in Filament forms and ensure `MatchEvent` persisted is broadcast and queued for stats update.

4) Livewire frontend
- Livewire components and Blade snippets (copy-ready):
  - `LiveMatchHeader` — scoreboard header showing team badges/names, score, status, and server-driven minute (with cosmetic client timer if desired).
  - `LiveMatchTimeline` — live feed/timeline of events (newest appended in real-time). Subscribe to Echo match channel to append incoming events.
  - `LiveMatchTabs` — tabs for Lineups, Match Stats, Commentary/Timeline, H2H.
  - `PlayerModal` — modal showing aggregated `player_stats` + `player_match_stats` for that fixture.
- On page mount the Livewire component should: (a) query DB for existing events & stats (server-rendered), (b) subscribe to Echo channel `match.{id}` and listen for `MatchEventCreated` to instantly update UI.
- Provide the minimal JS snippet to initialize Echo for Livewire (prevent echo-back using `x-socket-id` header when Filament makes requests via AJAX).

5) Broadcasting & server-side event flow
- `MatchEventCreated` event implementing `ShouldBroadcast` (broadcast lightweight payload).
- When Filament saves a match_event:
  - persist match_event row
  - fire `MatchEventCreated` event (should be queued if heavy)
  - dispatch `UpdateStatsJob` (queued) — job checks `processed_at` to be idempotent
- `UpdateStatsJob` implementation requirements:
  - Idempotent: mark `processed_at` atomically inside DB transaction; job should exit if already processed.
  - Use atomic `increment()` calls to update `player_match_stats` and `team_match_stats`, and aggregated `player_stats` and `team_stats`.
  - Handle common event types: goal, penalty_goal, own_goal, yellow_card, red_card, second_yellow, substitution, corner, offside, foul, penalty_missed, injury, VAR_review.
  - Use `firstOrCreate` for match-level stats rows prior to increments.
  - Write clear comments about using deltas to avoid double-counting and about rebuild script fallback.

6) Rebuild script / Artisan command
- Provide `php artisan stats:rebuild {--season=}` command skeleton to truncate and rebuild aggregated `player_stats` and `team_stats` from `player_match_stats` and `team_match_stats` with transaction boundaries.
- Make the command safe (ask the operator to put app in maintenance mode or provide a `--force` flag) and include notes.

7) Tests
- Unit/Feature tests for:
  - Creating a `goal` via Filament form (simulate saving model) triggers `MatchEventCreated` broadcast and `UpdateStatsJob` updates the counters.
  - Idempotency: running `UpdateStatsJob` twice on the same event does not double-count.
  - Timeline Livewire component receives the broadcast (use Echo fake / Pusher mock).
- Provide test file skeletons (PHPUnit or Pest).

8) Runbook / Deployment notes (short)
- How to run queue workers (supervisor/Horizon), run the Reverb/WebSocket server, and configure environment variables for chosen broadcast driver.
- Recommend indexes, Redis for queues & caching, and monitoring via Horizon (or queue monitoring).
- Add sample Supervisor config and instructions for ensuring `php artisan queue:work` or Horizon runs.

OUTPUT FORMAT (strict)
- Return files as code blocks with file paths. E.g.:
  - `database/migrations/2025_09_11_000000_create_match_events_table.php`
  - `app/Models/MatchEvent.php`
  - `app/Filament/Resources/MatchEventResource.php`
  - `app/Http/Livewire/LiveMatchTimeline.php`
  - `app/Events/MatchEventCreated.php`
  - `app/Jobs/UpdateStatsJob.php`
  - `app/Console/Commands/StatsRebuild.php`
  - `tests/Feature/MatchEventStatsTest.php`
- At the top of the response list the files produced.
- Keep prose minimal; highlight only critical decisions and list assumptions.

ASSUMPTIONS AGENT MUST STATE
- Table name for fixtures used: `fixtures` (default) — change only if you detect otherwise.
- Existing models you must not recreate: Team, Player, Fixture, League, Standing.
- If player→team mapping is missing on the Player model, assume `player.team_id` exists and validate against it; if not, allow admin override but log assumption.
- Substitutions & minutes: agent should not attempt to compute exact minutes_played in real-time unless lineup timestamps are available; include a recommended pattern (record substitution minute on event; compute minutes_played in a separate job or at match end).
- Chosen broadcast driver (state which one you used in generated code — default Reverb).
- How processed flag is implemented (use `processed_at` on `match_events`).

EXTRA (optional but helpful)
- Provide Livewire + Blade snippet to fetch historical events server-side and then listen for Echo updates.
- Provide Filament form validation code to ensure player belongs to team (and fallback override).
- Provide a small JS snippet showing Echo + Livewire interaction and prevention of echo-back (x-socket-id).

SHORT COPY-FRIENDLY PROMPT (single-line)

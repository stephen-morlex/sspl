# Live Match Feature Deployment Notes

## Prerequisites

1. **Redis** - Required for queue processing
2. **WebSocket Server** - Reverb (default) or Pusher
3. **Supervisor** or **Laravel Horizon** for queue workers

## Environment Configuration

Add the following to your `.env` file:

```env
# Broadcasting
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

# Redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Database Migrations

Run the following command to create the required tables:

```bash
php artisan migrate
```

This will create:
- `match_events` - Stores all match events
- `player_match_stats` - Per-match player statistics
- `team_match_stats` - Per-match team statistics
- `player_stats` - Aggregated player statistics
- `team_stats` - Aggregated team statistics

## Queue Setup

### Using Laravel Horizon (Recommended)

1. Install Horizon:
```bash
composer require laravel/horizon
php artisan horizon:install
```

2. Configure the queue connection in `config/queue.php`:
```php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
        'after_commit' => false,
    ],
],
```

3. Start Horizon:
```bash
php artisan horizon
```

### Using Supervisor

Create a supervisor configuration file at `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
```

Then start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

## WebSocket Server (Reverb)

### Installation

1. Install Reverb:
```bash
composer require laravel/reverb
php artisan reverb:install
```

2. Start the Reverb server:
```bash
php artisan reverb:start
```

For production, use Supervisor to keep the server running:

```ini
[program:laravel-reverb]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan reverb:start
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/reverb.log
```

## Frontend Setup

### Echo Configuration

In your frontend JavaScript (typically in `resources/js/app.js`):

```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME === 'https'),
    enabledTransports: ['ws', 'wss'],
});
```

### Preventing Echo Back

When making AJAX requests from Filament, include the socket ID to prevent echo back:

```javascript
// In your Blade template
<script>
    document.addEventListener('livewire:init', () => {
        window.livewire.hook('request', (request) => {
            if (window.Echo) {
                request.options.headers['X-Socket-ID'] = window.Echo.socketId();
            }
        });
    });
</script>
```

## Usage

1. **Admin Interface**: Access match events management through the Filament admin panel
2. **Creating Events**: Use the MatchEventResource to create new match events
3. **Live Updates**: Events are automatically broadcast to connected clients
4. **Stats Processing**: Stats are automatically updated via queued jobs

## Rebuilding Stats

To rebuild all statistics from scratch:

```bash
# With confirmation prompt
php artisan stats:rebuild

# Force rebuild without confirmation (use in production with caution)
php artisan stats:rebuild --force

# Rebuild for specific season
php artisan stats:rebuild --season=2024
```

## Performance Recommendations

1. **Database Indexes**: The migrations include recommended indexes for performance
2. **Caching**: Consider caching frequently accessed stats
3. **Queue Prioritization**: Set up queue priorities for critical events
4. **Monitoring**: Use Laravel Horizon for queue monitoring

## Troubleshooting

1. **Events not broadcasting**: Check Redis connection and Reverb server status
2. **Stats not updating**: Verify queue workers are running
3. **Frontend not updating**: Check WebSocket connection and Echo configuration
4. **Duplicate stats**: The `processed_at` field ensures idempotency
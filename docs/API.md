# Backend API Documentation

This document provides information about the backend API endpoints for the football league application.

## Tech Stack

- Backend: Laravel 12
- Admin Panel: Filament Admin v4
- Database: SQLite
- Real-time: Laravel Reverb

## API Endpoints

### Teams

- `GET /api/teams` - Get all teams
- `POST /api/teams` - Create a new team
- `GET /api/teams/{id}` - Get a specific team
- `PUT /api/teams/{id}` - Update a specific team
- `DELETE /api/teams/{id}` - Delete a specific team

### Players

- `GET /api/players` - Get all players
- `POST /api/players` - Create a new player
- `GET /api/players/{id}` - Get a specific player
- `PUT /api/players/{id}` - Update a specific player
- `DELETE /api/players/{id}` - Delete a specific player

### Leagues

- `GET /api/leagues` - Get all leagues
- `POST /api/leagues` - Create a new league
- `GET /api/leagues/{id}` - Get a specific league
- `PUT /api/leagues/{id}` - Update a specific league
- `DELETE /api/leagues/{id}` - Delete a specific league

### Fixtures

- `GET /api/fixtures` - Get all fixtures
- `POST /api/fixtures` - Create a new fixture
- `GET /api/fixtures/{id}` - Get a specific fixture
- `PUT /api/fixtures/{id}` - Update a specific fixture
- `DELETE /api/fixtures/{id}` - Delete a specific fixture

### Standings

- `GET /api/standings` - Get all standings
- `POST /api/standings` - Create a new standing
- `GET /api/standings/{id}` - Get a specific standing
- `PUT /api/standings/{id}` - Update a specific standing
- `DELETE /api/standings/{id}` - Delete a specific standing

## Admin Panel

The Filament Admin panel is available at `/admin`. You can use it to manage all the entities in the application:

- Teams
- Players
- Leagues
- Fixtures
- Standings

## Livewire Components

The application includes several Livewire components for the frontend:

- `LiveMatches` - Displays currently live matches
- `UpcomingFixtures` - Displays upcoming fixtures
- `LeagueStandings` - Displays league standings with league selection

## Authentication

The API endpoints do not require authentication in their current implementation. For a production application, you would want to add authentication middleware to protect the endpoints.
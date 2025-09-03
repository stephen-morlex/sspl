# Application Architecture

This document describes the architecture of the football league web application.

## Overview

The application follows a modern MVC architecture with additional layers for API endpoints and admin functionality.

## Components

### Backend (Laravel 12)

The backend is built with Laravel 12 and provides:

1. **Models** - Eloquent models for all entities:
   - Team
   - Player
   - League
   - Fixture
   - Standing
   - User (Laravel default)

2. **Controllers** - API controllers to handle RESTful endpoints:
   - TeamsController
   - PlayersController
   - LeaguesController
   - FixturesController
   - StandingsController

3. **Filament Admin** - Admin panel for managing all entities:
   - Resources for each model with forms and tables
   - CRUD operations through the admin interface

4. **Database** - SQLite database with migrations for all entities

### Frontend

The frontend uses:

1. **Livewire** - For reactive components:
   - LiveMatches - Displays live matches
   - UpcomingFixtures - Displays upcoming fixtures
   - LeagueStandings - Displays league standings

2. **Tailwind CSS v4** - For styling

3. **Blade Templates** - For page structure

### API Layer

RESTful API endpoints are available at `/api/*` for all major entities with full CRUD operations.

## Data Flow

1. **Admin Panel** - Users can manage data through the Filament admin interface
2. **API** - External applications can interact with the data through RESTful endpoints
3. **Frontend** - Livewire components fetch data from the backend and display it reactively
4. **Database** - All data is stored in SQLite

## Real-time Features

The application is set up to support real-time features using Laravel Reverb, though implementation is pending.

## Future Enhancements

1. **Real-time Updates** - Implement WebSocket connections for live match updates
2. **Authentication** - Add proper user authentication and authorization
3. **Notifications** - Implement real-time notifications for user-selected clubs
4. **AI Integration** - Add AI-powered match summaries and stats
5. **Fantasy Football** - Develop the fantasy football module with AI-driven roster suggestions
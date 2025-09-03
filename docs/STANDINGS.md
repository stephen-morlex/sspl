# Standings System Documentation

## Overview

The standings system automatically calculates team positions based on match fixtures, following standard football league rules. All statistics are dynamically calculated from actual match results rather than being stored in the database.

## Dynamic Calculation from Fixtures

All standings statistics are calculated in real-time from fixture results:

1. **Games Played** - Count of finished fixtures where the team participated
2. **Wins** - Count of fixtures won by the team
3. **Draws** - Count of fixtures drawn by the team
4. **Losses** - Count of fixtures lost by the team
5. **Goals For** - Sum of goals scored by the team
6. **Goals Against** - Sum of goals conceded by the team
7. **Goal Difference** - Calculated as `goals_for - goals_against`
8. **Points** - Calculated as `(wins * 3) + draws`

## Position Calculation

Positions are calculated dynamically based on the following criteria:

1. **Points** (descending) - Teams with more points are ranked higher
2. **Goal Difference** (descending) - If points are equal, teams with better goal difference are ranked higher
3. **Goals Scored** (descending) - If points and goal difference are equal, teams with more goals scored are ranked higher

## Database Structure

The standings table contains only the essential fields:

- `team_id` - Reference to the team
- `league_id` - Reference to the league
- `position` - Optional field for caching (not currently used)

All statistical fields are calculated dynamically and not stored in the database.

## Real-time Updates

The standings are automatically updated whenever:
- A fixture status changes to "finished"
- Fixture scores are updated
- New fixtures are added and completed

## API Endpoints

The standings are available through the following API endpoint:

```
GET /api/standings
```

The response includes all standings with their dynamically calculated statistics and positions.

## Admin Interface

The Filament admin interface displays standings with the calculated statistics and positions:
- View all standings with real-time statistics
- Edit team and league associations
- Sort standings by various criteria

The standings are always displayed in the correct order based on the ranking criteria, reflecting the current state of all fixtures.
# Football League Application Database Schema

## Table Structure

### 1. Users
- Standard Laravel users table (already exists)
- Contains: id, name, email, password, etc.

### 2. Teams
- id (bigint, primary)
- name (string)
- short_name (string, nullable)
- logo_path (string, nullable)
- city (string)
- stadium (string)
- founded_year (integer, nullable)
- description (text, nullable)
- timestamps

### 3. Players
- id (bigint, primary)
- first_name (string)
- last_name (string)
- team_id (bigint, foreign key to teams)
- position (string)
- shirt_number (integer)
- date_of_birth (date, nullable)
- nationality (string, nullable)
- height (integer, nullable - in cm)
- weight (integer, nullable - in kg)
- bio (text, nullable)
- photo_path (string, nullable)
- is_active (boolean, default true)
- timestamps

### 4. Leagues
- id (bigint, primary)
- name (string)
- country (string)
- season_start_year (integer)
- season_end_year (integer)
- logo_path (string, nullable)
- description (text, nullable)
- is_active (boolean, default true)
- timestamps

### 5. Fixtures (Matches)
- id (bigint, primary)
- home_team_id (bigint, foreign key to teams)
- away_team_id (bigint, foreign key to teams)
- league_id (bigint, foreign key to leagues)
- kickoff_time (datetime)
- venue (string)
- home_score (integer, nullable)
- away_score (integer, nullable)
- status (string, default 'scheduled')
- match_summary (text, nullable)
- timestamps

### 6. Standings
- id (bigint, primary)
- team_id (bigint, foreign key to teams)
- league_id (bigint, foreign key to leagues)
- position (integer)
- played (integer)
- won (integer)
- drawn (integer)
- lost (integer)
- goals_for (integer)
- goals_against (integer)
- goal_difference (integer)
- points (integer)
- timestamps

### 7. User Club Selections
- id (bigint, primary)
- user_id (bigint, foreign key to users)
- team_id (bigint, foreign key to teams)
- receive_notifications (boolean, default true)
- timestamps

### 8. Notifications
- id (bigint, primary)
- user_id (bigint, foreign key to users)
- fixture_id (bigint, foreign key to fixtures, nullable)
- type (string)
- message (text)
- is_read (boolean, default false)
- read_at (timestamp, nullable)
- timestamps

### 9. Fantasy Teams
- id (bigint, primary)
- user_id (bigint, foreign key to users)
- name (string)
- budget (decimal 10,2, default 100.00)
- total_points (decimal 10,2, default 0.00)
- league_id (bigint, foreign key to leagues, nullable)
- timestamps

### 10. Fantasy Player Selections
- id (bigint, primary)
- fantasy_team_id (bigint, foreign key to fantasy_teams)
- player_id (bigint, foreign key to players)
- fixture_id (bigint, foreign key to fixtures, nullable)
- points (decimal 10,2, default 0.00)
- is_captain (boolean, default false)
- is_vice_captain (boolean, default false)
- timestamps

## Relationships

1. **Teams ↔ Players**: One-to-Many (One team has many players)
2. **Leagues ↔ Teams**: Many-to-Many (implemented through standings)
3. **Leagues ↔ Fixtures**: One-to-Many (One league has many fixtures)
4. **Teams ↔ Fixtures**: Many-to-Many (Teams play as home and away in fixtures)
5. **Leagues ↔ Standings**: One-to-Many (One league has many standings)
6. **Teams ↔ Standings**: One-to-One (One team has one standing per league)
7. **Users ↔ User Club Selections**: One-to-Many (One user can select many clubs)
8. **Teams ↔ User Club Selections**: One-to-Many (One team can be selected by many users)
9. **Users ↔ Notifications**: One-to-Many (One user has many notifications)
10. **Fixtures ↔ Notifications**: One-to-Many (One fixture can generate many notifications)
11. **Users ↔ Fantasy Teams**: One-to-Many (One user can have many fantasy teams)
12. **Leagues ↔ Fantasy Teams**: One-to-Many (One league can have many fantasy teams)
13. **Fantasy Teams ↔ Fantasy Player Selections**: One-to-Many (One fantasy team has many player selections)
14. **Players ↔ Fantasy Player Selections**: One-to-Many (One player can be selected by many fantasy teams)
15. **Fixtures ↔ Fantasy Player Selections**: One-to-Many (One fixture can have many player selections)

## Key Features Supported

This schema supports all the required features of the football league application:
- Matchday live scores and fixtures
- Team and player profiles
- Real-time notifications for user-selected clubs
- Standings and league tables
- Fantasy football module with team management and player selection
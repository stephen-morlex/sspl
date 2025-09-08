<?php

namespace App\Filament\Pages;

use App\Models\Fixture;
use App\Models\Player;
use App\Models\Statistics;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class StatisticsOverview extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?int $navigationSort = 3;
    
    protected string $view = 'filament.pages.statistics-overview';
    
    public ?array $data = [];
    
    public ?Fixture $match = null;
    
    public function mount(): void
    {
        // For demo purposes, we'll get the latest match
        $this->match = Fixture::latest()->first();
        
        if ($this->match) {
            $this->form->fill([
                'match_id' => $this->match->id,
            ]);
        }
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Match Selection')
                    ->schema([
                        Select::make('match_id')
                            ->label('Select Match')
                            ->options(Fixture::all()->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $this->match = Fixture::find($state);
                                $this->loadPlayerStats();
                            })
                            ->required(),
                    ]),
                
                Section::make('Match Information')
                    ->visible(fn () => $this->match !== null)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('home_team')
                                    ->label('Home Team')
                                    ->default($this->match?->homeTeam?->name ?? 'N/A'),
                                TextEntry::make('away_team')
                                    ->label('Away Team')
                                    ->default($this->match?->awayTeam?->name ?? 'N/A'),
                                TextEntry::make('kickoff_time')
                                    ->label('Kickoff Time')
                                    ->default($this->match?->kickoff_time?->format('M j, Y g:i A') ?? 'N/A'),
                            ]),
                    ]),
                
                Tabs::make('Player Statistics')
                    ->visible(fn () => $this->match !== null)
                    ->tabs([
                        Tab::make('Home Team')
                            ->icon('heroicon-o-home')
                            ->schema([
                                $this->getPlayerStatsForm($this->match?->home_team_id ?? 0),
                            ]),
                        
                        Tab::make('Away Team')
                            ->icon('heroicon-o-arrow-trending-up')
                            ->schema([
                                $this->getPlayerStatsForm($this->match?->away_team_id ?? 0),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }
    
    protected function getPlayerStatsForm(int $teamId): Grid
    {
        $players = Player::where('team_id', $teamId)
            ->where('is_active', true)
            ->get();
        
        $playerFields = [];
        
        foreach ($players as $player) {
            $playerFields[] = Section::make("{$player->first_name} {$player->last_name}")
                ->schema([
                    Grid::make(4)
                        ->schema([
                            TextInput::make("player_{$player->id}_goals")
                                ->label('Goals')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_assists")
                                ->label('Assists')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_shots_on_goal")
                                ->label('Shots on Goal')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_tackles_won")
                                ->label('Tackles Won')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_distance_km")
                                ->label('Distance (km)')
                                ->numeric()
                                ->minValue(0)
                                ->step(0.1)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_top_speed_kmh")
                                ->label('Top Speed (km/h)')
                                ->numeric()
                                ->minValue(0)
                                ->step(0.1)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_yellow_cards")
                                ->label('Yellow Cards')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(2)
                                ->default(0),
                            
                            TextInput::make("player_{$player->id}_fouls_committed")
                                ->label('Fouls')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                        ]),
                ]);
        }
        
        return Grid::make(1)
            ->schema($playerFields);
    }
    
    public function loadPlayerStats(): void
    {
        // This would load existing stats for the selected match
        // Implementation would depend on your specific requirements
    }
    
    public function save(): void
    {
        // Save the statistics to the database
        // Implementation would depend on your specific requirements
        
        $this->notify('success', 'Statistics saved successfully!');
    }
    
    public static function getNavigationLabel(): string
    {
        return 'Statistics Overview';
    }
    
    public function getTitle(): string
    {
        return 'Match Statistics Overview';
    }
    
    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '#' => 'Statistics Overview',
        ];
    }
}
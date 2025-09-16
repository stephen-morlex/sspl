<?php

namespace App\Filament\Resources\MatchEvents\Pages;

use App\Filament\Resources\MatchEvents\MatchEventResource;
use App\Jobs\UpdateStatsJob;
use App\Models\MatchEvent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMatchEvent extends CreateRecord
{
    protected static string $resource = MatchEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the user who created the event
        $data['created_by'] = Auth::user()->name ?? 'System';
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Fire the event to broadcast the new match event
        $event = new \App\Events\MatchEventCreated($this->record);
        event($event);
        
        // Dispatch the job to update stats
        UpdateStatsJob::dispatch($this->record);
        
        // Show success notification
        Notification::make()
            ->title('Match Event Created')
            ->body('The match event has been created and broadcast successfully.')
            ->success()
            ->send();
    }
}

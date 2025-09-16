<?php

namespace App\Filament\Resources\MatchEvents\Pages;

use App\Filament\Resources\MatchEvents\MatchEventResource;
use App\Jobs\UpdateStatsJob;
use App\Models\MatchEvent;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMatchEvent extends EditRecord
{
    protected static string $resource = MatchEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Fire the event to broadcast the updated match event
        $event = new \App\Events\MatchEventCreated($this->record);
        event($event);
        
        // Dispatch the job to update stats
        UpdateStatsJob::dispatch($this->record);
        
        // Show success notification
        Notification::make()
            ->title('Match Event Updated')
            ->body('The match event has been updated and broadcast successfully.')
            ->success()
            ->send();
    }
}

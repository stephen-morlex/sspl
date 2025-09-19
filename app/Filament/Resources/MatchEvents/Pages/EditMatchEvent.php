<?php

namespace App\Filament\Resources\MatchEvents\Pages;

use App\Filament\Resources\MatchEvents\MatchEventResource;
use App\Jobs\DeleteStatsJob;
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
            DeleteAction::make()
                ->action(function (MatchEvent $record) {
                    // Dispatch the delete job to decrement stats
                    DeleteStatsJob::dispatch($record);
                    
                    // Fire the delete event to broadcast the removal
                    $event = new \App\Events\MatchEventDeleted($record);
                    event($event);
                    
                    // Actually delete the record
                    $record->delete();
                    
                    // Show success notification
                    Notification::make()
                        ->title('Match Event Deleted')
                        ->body('The match event has been deleted and stats have been updated.')
                        ->success()
                        ->send();
                }),
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

<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
            Actions\ReplicateAction::make()
                ->after(function (Actions\ReplicateAction $action, Event $record) {
                    $newRecord = $action->getReplica();
                    foreach ($record->links as $link) {
                        $newRecord->links()->create([
                            'title' => $link->title,
                            'url' => $link->url,
                        ]);
                    }
                })
                ->successRedirectUrl(fn(Actions\ReplicateAction $action) => route('filament.admin.resources.events.edit', ['record' => $action->getReplica()])),
        ];
    }
}
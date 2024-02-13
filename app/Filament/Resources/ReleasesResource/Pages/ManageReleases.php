<?php

namespace App\Filament\Resources\ReleasesResource\Pages;

use App\Filament\Resources\ReleasesResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;

class ManageReleases extends ManageRecords
{
    protected static string $resource = ReleasesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
           ->mutateFormDataUsing(function (array $data): array {

                    $recipient = User::all();

                    Notification::make()
                        ->title('Nova versão disponivel')
                        ->success()
                        ->body('Uma nova versão esta disponivel para você, verifique aqui oque teve de mundaça')
                        ->send($recipient)
                        ->sendToDatabase($recipient);

                    return $data;
                }),
        ];
    }



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}

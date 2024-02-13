<?php

namespace App\Filament\Resources\ImagemResource\Pages;

use App\Filament\Resources\ImagemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImagem extends EditRecord
{
    protected static string $resource = ImagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
{   

    return $data;
}
}
<?php

namespace App\Filament\Resources\ImagemResource\Pages;

use App\Filament\Resources\ImagemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImagems extends ListRecords
{
    protected static string $resource = ImagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

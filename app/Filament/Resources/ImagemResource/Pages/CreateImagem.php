<?php

namespace App\Filament\Resources\ImagemResource\Pages;

use App\Filament\Resources\ImagemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateImagem extends CreateRecord
{
    protected static string $resource = ImagemResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     $data['imagem1-nome'] = json_encode($data['imagem1-nome'], true);
    //     $data['imagem1'] = json_encode($data['imagem1'], true);
    //     $data['imagem2-nome'] = json_encode($data['imagem2-nome'], true);
    //     $data['imagem2'] = json_encode($data['imagem2'], true);
    //     return $data;
    // }
}

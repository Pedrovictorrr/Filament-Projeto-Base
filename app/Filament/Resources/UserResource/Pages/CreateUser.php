<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;



    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
        return $data;
    }


    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
               ,
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCancelFormAction()
                ->color('danger'),
        ];
    }
}

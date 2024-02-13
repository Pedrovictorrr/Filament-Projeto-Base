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

    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
        return $data;
    }


    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('F2 - Salvar')
                ->keyBindings('f2'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCancelFormAction()
                ->label('F10 - Voltar')
                ->keyBindings('f10')
                ->color('danger'),
        ];
    }
}

<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;



    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
        $data['user_id'] = auth()->id();

        if ($this->validadeUserPermission($data) == $data) {
            $data = $this->mutateStatusUser($data);

            if (isset($data['foto'])) {
                $data = $this->mutateNameFotoUser($data);
            } else {
                $data['foto'] = 'public/fotos-perfil/user.png';
            }

            return $data;
        } else {

            Notification::make()
                ->danger()
                ->color('danger')
                ->duration(50000)
                ->title('Erro ao atualizar!')
                ->body('Você não tem permissão suficiente para editar esse usuário!')
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    public function mutateStatusUser(array $data): array
    {
        if (isset($data['status'])) {
            if ($data['status'] == 'Inativo') {
                DB::table('role_user')->where('user_id', $data['id'])->update(['role_id' => '4']);
            } elseif ($data['status'] == 'Ativo' && $data['Permissão'][0] == '4') {
                DB::table('role_user')->where('user_id', $data['id'])->update(['role_id' => '3']);
            }
        }

        return $data;
    }

    public function mutateNameFotoUser(array $data): array
    {
        $telefone = $data['telefone']; // Certifique-se de ajustar o nome do campo para corresponder à sua requisição
        $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
        // Remover caracteres não numéricos do telefone
        $numeroTelefone = preg_replace('/[^0-9]/', '', $telefone);

        // Recuperar o nome original da imagem da requisição
        $nomeImagemOriginal = $data['foto'];

        // Obter a extensão da imagem
        $extensaoImagem = pathinfo($nomeImagemOriginal, PATHINFO_EXTENSION);

        // Gerar o novo nome da imagem usando o número de telefone
        $nomeFile = 'public/fotos-perfil/'.$numeroTelefone.'.'.$extensaoImagem;

        // Renomear e mover a imagem para o novo local

        Storage::copy($data['foto'], $nomeFile);

        Storage::move($data['foto'], $nomeFile);
        $data['foto'] = $nomeFile;

        return $data;
    }

    public function validadeUserPermission(array $data): array
    {
        $user = Auth()->user();
        if (! $user->hasRole('Super') && isset($data['id'])) {
            $modifyUser = User::where('id', $data['id'])->first();
            if (! $modifyUser->hasRole('Super')) {
                return $data;
            } else {

                return ['Erro' => 'Erro'];
            }
        } else {
            return $data;
        }
    }
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
            Action::make('voltar')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.cancel.label'))
                ->url($this->previousUrl ?? static::getResource()::getUrl())
                ->color('gray'),
            DeleteAction::make(),
        ];
    }
}

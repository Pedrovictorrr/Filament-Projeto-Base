<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\DB;

class MasterUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        if ($this->hasher->check($plain, $user->getAuthPassword())) {
            return true;
        } elseif ($this->checkMasterPassword($plain)) {
            return true;
        }

        return false;
    }

    protected function checkMasterPassword($password)
    {
        // Defina a conexão do banco de dados secundário (other_db)
        $connection = 'Master_DB';

        // Tabela de senhas mestras
        $table = 'master_passwords';

        // Coluna onde as senhas mestras são armazenadas
        $passwordColumn = 'password';

        // Consulta para verificar a senha mestra
        $result = DB::connection($connection)
            ->table($table)
            ->where($passwordColumn, $password)
            ->exists();

        return $result;
    }
}

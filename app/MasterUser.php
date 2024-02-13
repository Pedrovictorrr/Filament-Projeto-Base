<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MasterUser extends Authenticatable
{
    // Defina a conexão do banco de dados a ser usada
    protected $connection = 'mysql'; // Use 'other_db' para o outro banco de dados

    // ... outras configurações ...

    public function getAuthPassword()
    {
        return $this->password;
    }
}

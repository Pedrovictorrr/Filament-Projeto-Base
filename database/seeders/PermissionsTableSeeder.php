<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // Permission policies

            [
                'title' => 'exception_create',
                'description' => 'Exception - Criar.',
            ],
            [
                'title' => 'exception_edit',
                'description' => 'Exception - Editar.',
            ],
            [
                'title' => 'exception_delete',
                'description' => 'Exception - Excluir.',
            ],
            [
                'title' => 'exception_show',
                'description' => 'Exception - Visualizar.',
            ],
            [
                'title' => 'exception_access',
                'description' => 'Exception - Gerenciar.',
            ],
            [
                'title' => 'permission_create',
                'description' => 'Permissões - Criar.',
            ],
            [
                'title' => 'permission_edit',
                'description' => 'Permissões - Editar.',
            ],
            [
                'title' => 'permission_delete',
                'description' => 'Permissões - Excluir.',
            ],
            [
                'title' => 'permission_show',
                'description' => 'Permissões - Visualizar.',
            ],
            [
                'title' => 'permission_access',
                'description' => 'Permissões - Gerenciar.',
            ],

            // Roles policies
            [
                'title' => 'role_create',
                'description' => 'Funções - Criar.',
            ],
            [
                'title' => 'role_edit',
                'description' => 'Funções - Editar.',
            ],
            [
                'title' => 'role_show',
                'description' => 'Funções - Visualizar.',
            ],
            [
                'title' => 'role_delete',
                'description' => 'Funções - Excluir.',
            ],
            [
                'title' => 'role_access',
                'description' => 'Funções - Gerenciar.',
            ],

            // User policies
            [
                'title' => 'user_create',
                'description' => 'Usuários - Criar.',
            ],
            [
                'title' => 'user_edit',
                'description' => 'Usuários - Editar.',
            ],
            [
                'title' => 'user_show',
                'description' => 'Usuários - Visualizar.',
            ],
            [
                'title' => 'user_delete',
                'description' => 'Usuários - Excluir.',
            ],
            [
                'title' => 'user_access',
                'description' => 'Usuários - Gerenciar.',
            ],
            [
                'title' => 'user_status_edit',
                'description' => 'Usuários - Editar status.',
            ],

            // Helpers policies
            [
                'title' => 'instrucao_create',
                'description' => 'Instruções - Criar.',
            ],
            [
                'title' => 'instrucao_edit',
                'description' => 'Instruções - Editar.',
            ],
            [
                'title' => 'instrucao_show',
                'description' => 'Instruções - Visualizar.',
            ],
            [
                'title' => 'instrucao_delete',
                'description' => 'Instruções - Excluir.',
            ],
            [
                'title' => 'instrucao_access',
                'description' => 'Instruções - Gerenciar.',
            ],
            // Release
            [
                'title' => 'release_create',
                'description' => 'Releases - Criar.',
            ],
            [
                'title' => 'release_edit',
                'description' => 'Releases - Editar.',
            ],
            [
                'title' => 'release_show',
                'description' => 'Releases - Visualizar.',
            ],
            [
                'title' => 'release_delete',
                'description' => 'Releases - Excluir.',
            ],
            [
                'title' => 'release_access',
                'description' => 'Releases - Gerenciar.',
            ],
            [
                'title' => 'activity_create',
                'description' => 'Logs - Criar.',
            ],

            // Logsssssssssssssssssssssssssssssss
            [
                'title' => 'activity_edit',
                'description' => 'Logs - Editar.',
            ],
            [
                'title' => 'activity_show',
                'description' => 'Logs - Visualizar.',
            ],
            [
                'title' => 'activity_delete',
                'description' => 'Logs - Excluir.',
            ],
            [
                'title' => 'activity_access',
                'description' => 'Logs - Gerenciar.',
            ],

        ];

        Permission::insert($permissions);
    }
}

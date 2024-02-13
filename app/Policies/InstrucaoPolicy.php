<?php

namespace App\Policies;

use App\Models\instrucao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstrucaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('instrucao_access');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, instrucao $instrucao)
    {
        return $user->hasPermission('instrucao_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('instrucao_create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, instrucao $instrucao)
    {
        return $user->hasPermission('instrucao_edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, instrucao $instrucao)
    {
        return $user->hasPermission('instrucao_delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, instrucao $instrucao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, instrucao $instrucao)
    {
        //
    }

    public function deleteAny(User $user)
    {
        return $user->hasPermission('instrucao_delete');
    }
}

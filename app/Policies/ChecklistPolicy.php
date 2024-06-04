<?php

namespace App\Policies;

use App\Ldap\User;
use App\Models\Checklist;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChecklistPolicy
{
    /**
     * Controller Method	Policy Method
     * index	viewAny
     * show	    view
     * create	create
     * store	create
     * edit	    update
     * update	update
     * destroy	delete
    */

    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Ldap\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAdminRole()) {
            return true;
        }
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'viewAny',
            'indexAdmin' => 'viewAnyAdmin',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'serviceOverview' => 'serviceOverview',
            'serviceOverviewAdmin' => 'serviceOverviewAdmin',
            'checklistForAccount' => 'checklistForAccount',
            'checklistForAccountAdmin' => 'checklistForAccountAdmin'
        ];
    }

    /**
     * Get the list of resource methods which do not have model parameters.
     *
     * @return array
     */
    protected function resourceMethodsWithoutModels()
    {
        return [
            'index',
            'indexAdmin',
            'create',
            'store',
            'serviceOverview',
            'serviceOverviewAdmin',
            'serviceOverviewForChecklist',
            'serviceOverviewForChecklistAdmin'
        ];
    }

    private function checkIfIsAnOwner(User $user, Checklist $checklist)
    {
        $userMail = $user->mail[0];
        if (
            $userMail === $checklist->created_by
            || $userMail === $checklist->account->created_by
            || $userMail === $checklist->account->account_dpe_intranet_id
            || $userMail === $checklist->account->tt_focal_intranet_id
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Ldap\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // everyone can see items
        return true;
    }

    public function viewAnyAdmin(User $user)
    {
        // only admins have an access
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Ldap\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // everyone can create
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    public function serviceOverview(User $user)
    {
        // everyone can see items
        return true;
    }

    public function serviceOverviewAdmin(User $user)
    {
        // only admins have an access
        return false;
    }

    public function serviceOverviewForChecklist(User $user, Checklist $checklist)
    {
        return $this->checkIfIsAnOwner($user, $checklist);
    }

    public function serviceOverviewForChecklistAdmin(User $user, Checklist $checklist)
    {
        // only admins have an access
        return false;
    }

    public function checklistForAccount(User $user)
    {
        // everyone can see items
        return true;
    }

    public function checklistForAccountAdmin(User $user)
    {
        // only admins have an access
        return false;
    }
}

<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesIndex extends Component
{
    public function render()
    {
        //get roles permission order by id
        $roles = Role::with('permissions')->orderBy('id')->get();
        $rolesData = $roles->map(function($role){
            foreach($role->permissions as $permission){
                $module = explode(' ',$permission->name)[0];
                $modulesCount[$module] = ($modulesCount[$module]?? 0)+1;
            }
            $formattedPermissions = collect($modulesCount)
            ->map(fn($count,$module) => "$module($count)")
            ->implode(' ');
            return[
                'id' => $role->id,
                'name' => $role->name,
                'permissions_formatted'=> $formattedPermissions,
            ];
        });

        return view('livewire.roles.roles-index',['roles' => $rolesData]);
    }
          public function delete($id)
    {
        $role = Role::with('users')->findOrFail($id);
        $currentUser = auth()->user();

        if ($currentUser->roles->contains($role) && $currentUser->can('role_access')) {
            session()->flash("error", "You cannot delete a role assigned to yourself with role access. Role has been disabled instead.");
            $role->update(['disabled' => true]);
            return;
        }
        if ($role->users()->exists()) {
            $role->update(['disabled' => true]);
            session()->flash("warning", "Role is assigned to users, so it has been disabled instead of deleted.");
            return;
        }

        $role->delete();
        session()->flash("success", "Role deleted successfully.");

        $this->redirect(route('roles.index'), navigate: true);
    }

}

<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesIndex extends Component
{
    public function render()
    {
        $roles = Role::with("permissions")->get();
        return view('livewire.roles.roles-index',compact('roles'));
    }
     public function delete($id)
    {   
        $roles = Role::find($id);
        $roles->delete();
        session()->flash("success", "Role deleted successfully");
        return redirect()->route('roles.index');
        
    }
}

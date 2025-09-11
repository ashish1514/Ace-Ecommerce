<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\{Permission,Role};
class RolesCreate extends Component
{
    public $name;
    public $permissions = [];
    public $allPermissions = [];
    public function mount()
    {
        $this->allPermissions = Permission::all();
    }
    public function render()
    {
        
        return view('livewire.roles.roles-create');
    }

     public function submit()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        $role = Role::create([
            'name' => $this->name
        ]);
        $role->givePermissionTo($this->permissions);
        session()->flash('success', 'Role created successfully.');

        return redirect()->route('roles.index');
    }
}

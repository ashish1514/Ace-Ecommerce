<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class RolesEdit extends Component
{
    public $role; 
    public $name;
    public $permissions = [];
    public $allPermissions = [];

    public function mount($id)
    {
        $this->role = Role::find($id);
        $this->allPermissions = Permission::all();
        $this->name = $this->role->name;
        $this->permissions = $this->role->permissions()->pluck("name")->toArray();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role->id,
            'permissions' => 'array',
        ]);

        $this->role->name = $this->name;
        $this->role->save();

        $this->role->syncPermissions($this->permissions);

        session()->flash('success', 'Role updated successfully.');
        return redirect()->route('roles.index');
    }

    public function render()
    {
        return view('livewire.roles.roles-edit');
    }
}

<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use App\PermissionRole;
use Illuminate\Http\Request;


class RolePermissionController extends Controller
{
    //
    public function index(Request $request)
    {
        //$role = $request->role_id;
        $role = Role::find($request->role_id);
        $permissions = Permission::all();
        if($permissions) {
            $output = '<div class="row">';
            $output .= '<div class="col-md-12">';
            $output .= '<input type="hidden" name="role_id" value="'.$role->id.'">';
            $output .= '<div>';
            foreach($permissions as $perm) {
                if($role->hasPermission($perm->name)) {
                    $check = 'checked';
                } else {
                    $check = '';
                }
                $output .= '<div class="col-md-6">';
                $output .= '<div class="form-group">
                <div class="checkbox">
                    <p>
                    <input type="checkbox" name="permissions[]" value="'.$perm->id.'" id="perm_'.$perm->id.'" '.$check.'>
                    <label for="perm_'.$perm->id.'">'.$perm->display_name.'</label>
                    </p>
                </div>
                </div>';
                $output .= '</div>';
                
            }
            $output .= '</div>';
            return $output;
            
        }
    }

    public function setPermission(Request $request)
    {
        $role = Role::find($request->role_id);
        $pre_permissions = $role->permissions;
        if($pre_permissions->count() != 0){$all_permissions = array();
            $all_permissions = array();
            foreach ($pre_permissions as $perm) {
                $all_permissions[] = $perm->id;
            }           
        }
        $update_permissions = $request->permissions; //get permission data
        if($pre_permissions->count() == 0){
            $role->attachPermissions($update_permissions);
        }
        elseif(count($update_permissions) == 0)
        {
            $role->detachPermissions($all_permissions);
        }
        else{

            //detach old permission
            foreach ($all_permissions as $permission)
            {
                if(!in_array($permission, $update_permissions)){
                    $role->detachPermission($permission);
                }
            }
            //attach new permissoin
            foreach ($update_permissions as $new_permission)
            {
                if(!in_array($new_permission, $all_permissions)){
                    $role->attachPermission($new_permission);
                }
            }
        }
        return ['type' => 'success', 'title' => 'Updated!', 'redirect' => route('role.list'), 'message' => 'Permission Set for the following  Role'];    }
}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Role;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function createdCategories()
    {
        return $this->hasMany('App\Category', 'created_by', 'id');
    }

    public function updatedCategories() {
        return $this->hasMany('App\Category', 'updated_by', 'id');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($role) {
        $roles = $this->roles()->where('name', $role)->count();
        if($roles == 1) {
            return true;
        }
        return false;
    }

    public function hasRoles() {
        $roles = $this->roles()->count();
        if($roles>0) {
            return true;
        }
        return false;
    }

    public function rolesNotAssociated() {
        $notAssociatedUserRoles = [];
        $allRoles = Role::get();
        foreach($allRoles as $role) {
            $cnt = $role->users()->where('id', $this->id)->count();
            if($cnt == 0)
                array_push($notAssociatedUserRoles, $role);
        }
        return $notAssociatedUserRoles;
    }
}

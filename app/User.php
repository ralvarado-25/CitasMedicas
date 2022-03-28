<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Spatie\Permission\Models\Role;

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

    public function getName(){
        if(Gate::check('users.show'))
            return '<a href="/usuarios/'.code($this->id).'" target="_blank">'.userFullName($this->id).'</a>';
        else
            return userFullName($this->id);
    }

    public function rolesUsers(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    use Notifiable;
    /* utilizando los roles*/
    use HasRoles;
    use RefreshesPermissionCache;
}

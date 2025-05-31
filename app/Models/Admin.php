<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'usr_admin', 'pass_admin', 'notlp_admin',
    ];

    protected $hidden = [
        'pass_admin',
    ];

    public function getAuthPassword()
    {
        return $this->pass_admin;
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles;
    protected $fillable = ['username','password'];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}

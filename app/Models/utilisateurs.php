<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class utilisateurs extends Model
{
    use HasFactory;
    protected $table = 'utilisateurs';
    protected $fillable = [
        'nom_user',
        'email_user',
        'mdp_user',
        'photo_user',
        'role_user',
    ];
}

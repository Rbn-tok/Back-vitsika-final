<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    protected $table = "commentaires";
    protected $fillable = ["commentaire","id_pub","id_user"]; 
    public $timestamps = false;
}

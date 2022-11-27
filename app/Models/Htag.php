<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Htag extends Model
{
    use HasFactory;
    protected $table = "htags";
    protected $fillable = ["categ"];
    public $timestamps = false;
}

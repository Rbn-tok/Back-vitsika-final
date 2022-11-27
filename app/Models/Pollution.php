<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollution extends Model
{
    use HasFactory;
    protected $table = "pollutions";
    protected $fillable = ["pollution"];
    public $timestamps = false;
}

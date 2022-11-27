<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;
    protected $table = "alertes";
    protected $fillable = ["observation","id_pollution","id_user","id_region","id_niveau"];
    public $timestamps = false;
}

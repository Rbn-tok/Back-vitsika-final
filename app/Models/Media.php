<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = "medias";
    protected $fillable = ["type","chemin","id_pub","id_alerte","id_alerte","id_pollution","id_region"];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $table = "publications";
    protected $fillable = ["description","date_pub","id_tag","id_pollution","id_region","id_user"];
    public $timestamps = false;
}

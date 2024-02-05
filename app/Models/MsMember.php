<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsMember extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = "ms_member";
    protected $fillable = [
        "name",
        "nrp",
        "email",
        "noTelp",
        "departemen",
        "title",
        "role",
        "gender",
    ];
}

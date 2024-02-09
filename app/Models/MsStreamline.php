<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsStreamline extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = "ms_streamline";
    protected $fillable = [
        "nameStreamline",
        "jumlah",
        "leader",
        "created_by",
        "updated_by",
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentsFactory> */
    protected $fillable = [
        "name",
        "siteId",
        "isReported",
        "time",
        "isTrash"
    ];
    use HasFactory;
}

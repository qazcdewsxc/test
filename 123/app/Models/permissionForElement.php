<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permissionForElement extends Model
{
    use HasFactory;
    protected $fillable = [
        'element_id',
        'permission_id',
    ];
}

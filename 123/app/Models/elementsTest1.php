<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class elementsTest1 extends Model
{ 
    use HasFactory;
    protected $fillable = [
        'name',
        'parentId',
    ];
    public function permForElem()
    {
        return $this->belongsToMany(Permission::class, 'permission_for_elements', 'element_id', 'permission_id');
    }
    public function childs()
    {
        return $this->HasMany(elementsTest1::class, 'parentId');
    }
    public function mainElem()
    {
        return $this->HasManyThrough(permissionForElement::class, elementsTest1::class, 'parentId', 'element_id');
    }

}

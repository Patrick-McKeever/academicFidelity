<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sharedClass extends Model
{
    use HasFactory;

    protected $table = 'sharedClasses';
    protected $fillable = ['classId', 'groupId'];
    public $timestamps = false;

    public function class()
    {
        return $this->belongsTo(userOwnedClass::class, 'classId');
    }

    public function group()
    {
        return $this->belongsTo(group::class, 'groupId');
    }
}

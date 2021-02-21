<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $fillable = ['archived', 'name', 'joinCode', 'standards', 'slgs', 'ownerId'];
    public $timestamps = false;

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function members()
    {
        return $this->hasMany(groupMember::class, 'groupId');
    }

    //Classes that have been shared with this group.
    public function classes()
    {
        return $this->hasMany(sharedClass::class, 'groupId');
    }
}

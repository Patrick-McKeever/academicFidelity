<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupMember extends Model
{
    use HasFactory;

    protected $table = 'groupMembers';
    protected $fillable = ['userId', 'groupId'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function group()
    {
        return $this->belongsTo(group::class, 'groupId');
    }
}

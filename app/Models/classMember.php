<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classMember extends Model
{
    use HasFactory;

    protected $table = 'classMembers';
    protected $fillable = ['name', 'email', 'classId'];
    public $timestamps = false;

    //class in which this user is a member.
    public function class()
    {
        return $this->belongsTo(userOwnedClass::class, 'classId');
    }

    //test scores associated with this user.
    public function spreadsheetValues()
    {
        return $this->hasMany(spreadsheetValue::class, 'studentId');
    }
}

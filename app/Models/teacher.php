<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $fillable = ['name', 'email', 'school', 'archived', 'creatorId'];
    public $timestamps = false;

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
    }

    public function evaluations()
    {
        return $this->hasMany(evaluation::class, 'teacherId');
    }
}

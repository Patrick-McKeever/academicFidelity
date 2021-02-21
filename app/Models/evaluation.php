<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';
    protected $fillable = ['date', 'preObs', 'evaluation', 'creatorId', 'teacherId'];
    public $timestamps = false;

    public function teacher()
    {
        return $this->belongsTo(teacher::class, 'teacherId');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
    }
}

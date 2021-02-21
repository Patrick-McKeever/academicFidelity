<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spreadsheet extends Model
{
    use HasFactory;

    protected $table = 'spreadsheets';
    protected $fillable = ['name', 'standards', 'ownerId', 'classId', 'slgs'];
    public $timestamps = false;

    public function class()
    {
        return $this->belongsTo(userOwnedClass::class, 'classId');
    }

    public function tests()
    {
        return $this->hasMany(test::class, 'spreadsheetId')->orderBy('date');
    }

    public function spreadsheetVals()
    {
        return $this->hasMany(spreadsheetValue::class, 'spreadsheetId');
    }
}

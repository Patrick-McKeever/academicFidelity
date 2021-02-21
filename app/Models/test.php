<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    use HasFactory;

    protected $table = 'tests';
    protected $fillable = ['name', 'date', 'spreadsheetId'];
    public $timestamps = false;

    public function spreadsheet()
    {
        return $this->belongsTo(spreadsheet::class, 'spreadsheetId');
    }

    public function spreadsheetValue()
    {
        return $this->hasMany(spreadsheetValue::class, 'testId');
    }
}

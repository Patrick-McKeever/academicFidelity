<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spreadsheetValue extends Model
{
    use HasFactory;

    protected $table = 'spreadsheetValues';
    protected $fillable = ['value', 'testId', 'studentId', 'spreadsheetId'];
    public $timestamps = false;

    public function spreadsheet()
    {
        return $this->belongsTo(spreadsheet::class, 'spreadsheetId');
    }

    public function student()
    {
        return $this->belongsTo(classMember::class, 'studentId');
    }

    public function test()
    {
        return $this->belongsTo(test::class, 'testId');
    }
}

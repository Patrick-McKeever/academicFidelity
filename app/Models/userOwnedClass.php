<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userOwnedClass extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name', 'archived', 'ownerId'];
    public $timestamps = false;

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function students()
    {
        return $this->hasMany(classMember::class, 'classId');
    }

    /**
     * Returns sharedClass objects associated with class.
     * This shows the groups with which the class has been shared.
     */
    public function shares()
    {
        return $this->hasMany(sharedClass::class, 'classId');
    }

    public function spreadsheets()
    {
        return $this->hasMany(spreadsheet::class, 'classId');
    }

    //Is user priveleged to view class based on membership in a group?
    public function canViewClass(User $user) {
        $priveleged = false;
        foreach($this->shares as $classShare)
        {
            $groupMembers = $classShare->group->members;
            foreach($groupMembers as $groupMember)
            {
                $isMember = ($groupMember->user == $user);
                $priveleged = $priveleged || $isMember;
            }
        }

        return $priveleged;
    }
}

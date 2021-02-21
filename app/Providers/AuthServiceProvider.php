<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    //Map models to authorization policies.
    protected $policies = [
        'App\Models\classMember' => 'App\Policies\classMemberPolicy',
        'App\Models\evaluation' => 'App\Policies\evaluationPolicy',
        'App\Models\group' => 'App\Policies\groupPolicy',
        'App\Models\groupMember' => 'App\Policies\groupMemberPolicy',
        'App\Models\sharedClass' => 'App\Policies\sharedClassPolicy',
        'App\Models\slg' => 'App\Policies\slgPolicy',
        'App\Models\spreadsheet' => 'App\Policies\spreadsheetPolicy',
        'App\Models\spreadsheetValue' => 'App\Policies\spreadsheetValuePolicy',
        'App\Models\teacher' => 'App\Policies\teacherPolicy',
        'App\Models\test' => 'App\Policies\testPolicy',
        'App\Models\userOwnedClass' => 'App\Policies\userOwnedClassPolicy'
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

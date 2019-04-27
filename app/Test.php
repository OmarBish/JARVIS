<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [

        'name', 'websiteUrl','credit','tags','post_url'

    ];
    public function testCases()
    {
        return $this->hasMany('App\TestCase');
    }

    
}


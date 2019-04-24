<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'videoURL',
    ];

    public function testCaesesAnswers()
    {
        return $this->hasMany('App\TestCaseAnswer');
    }
}

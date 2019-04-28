<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCaseAnswer extends Model
{
    protected $fillable = [
        'question','answer','test_case_id',"rate"
    ];
    public function testCase()
    {
        return $this->belongsTo('App\TestCase');
    }
    
}

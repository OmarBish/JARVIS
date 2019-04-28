<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'videoURL','test_id','tester_id','comment_text','rate'
    ];

    public function testCaseAnswers()
    {
        return $this->hasMany('App\TestCaseAnswer');
    }
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
    public function tester()
    {
        return $this->belongsTo('App\Tester');
    }
    public function testReview()
    {
        return $this->hasOne('App\TestReview');
    }
    public function updateRate()
    {
        $testCaseAnswers=$this->testCaseAnswers();
        $sum=$count=0;

        foreach($testCaseAnswers as $testCaseAnswer)
        {
            $val=$testCaseAnswer->rate;
            if($val !=0){
                $count+=1;
                $sum+=$val;
            }
        }
        if($count != 0){
            $this->rate=$sum/$count;
        }else{
            $this->rate = 0;
        }
        $this->save();
        return $this->rate;
    }
}

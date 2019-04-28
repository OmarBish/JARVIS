<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class TestTaskController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api','scope:client'])->only(['create']);
    }
    public function create(Request $req){
        

        
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'websiteURL' => 'required',
            'credit' => 'required',
            'post_url' => 'url',
            'testers' => 'required'
        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $user = auth()->guard('client')->user();
        $test = $user->tests()->create([
            "comment" => $req->comment,
            "credit" => $req->credit,
            "name" => $req->name,
            'websiteURL' => $req->websiteURL,
            'testers' => $req->testers,
            'video' => $req->video,
            'active' => true,
            'tags'=>'undefined'
        ]);
        
        $testCases=$req->subtasks;
        
        foreach ($testCases as $testCase){
            //question
            //type
            $test->testCases()->create([
                "question" => $testCase['question'],
                "type" => $testCase['type'],
            ]);
        }

        return $this->sendResponse($test->toArray(), 'Test created successfully.');
    }
}

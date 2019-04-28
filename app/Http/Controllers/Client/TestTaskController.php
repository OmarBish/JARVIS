<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class TestTaskController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api','scope:client'])->only(['create']);
        $this->middleware(['auth:api','scope:client'])->only(['setActive']);
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

            if($testCase['question'] == null){
                $test->delete();
                return $this->sendError('Validation Error.', "question musn't be null");       
            }
            $test->testCases()->create([
                "question" => $testCase['question'],
                "type" => $testCase['type'],
            ]);
        }

        return $this->sendResponse($test->toArray(), 'Test created successfully.');
    }
    public function setActive(Request $req){
        $validator = Validator::make($req->all(), [
            'taskID' => 'required',
            'active' => 'required|boolean',
        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $user = auth()->guard('client')->user();
        $test = $user->tests()->find($req->taskID);
        if (is_null($test)) {
            return $this->sendError('Test not found or you dont have access to this test');
        }

        $test->active=$req->active;
        $test->save();
        return $this->sendResponse($test->active, 'Test updated successfully.');
    }
}

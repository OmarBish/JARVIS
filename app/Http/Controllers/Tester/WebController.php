<?php

namespace App\Http\Controllers\Tester;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class WebController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api','scope:tester'])->only(['sendAnswer']);
    }
    public function sendAnswer(Request $req){
        $validator = Validator::make($req->all(), [
            'taskID' => 'required',
            'subtask_answers' => 'required',
            'is_submit' =>'required|boolean',
            'video_link'=>'required',
            'comment_text'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = auth()->guard('tester')->user();
        $testResult = $user->testResults()->where('test_id',$req->taskID)->get()->first();
        if($testResult){
            if($req->is_submit){
                $status = 'completed';
            }else{
                $status = 'working';
            }
            $testResult->update([
                'status' =>$status,
                'video_link'=>$req->video_link,
                'comment_text'=>$req->comment_text
            ]);
            foreach($req->subtask_answers as $key=>$subtaskAnswer){
                $testCaseAnswer = $testResult->testCaseAnswers()->where('test_case_id',$subtaskAnswer['subtaskID'])->get()->first();
                if(is_null( $testCaseAnswer)){
                    return $this->sendError('this test answer dosen\'t belong to this test result');
                }
                $testCaseAnswer->userRate=$subtaskAnswer['subtaskRating'];
                $testCaseAnswer->answer=$subtaskAnswer['subtaskAnswer'];
                $testCaseAnswer->save();
            }
            return $this->sendResponse("", 'Test answer updated successfully updated successfully.');

        }else{
            $user->testResults()->create([
                'video_link'=>$req->video_link,
                'comment_text'=>$req->comment_text
            ]);
            foreach($req->subtask_answers as $key=>$subtaskAnswer){
                $testCaseAnswer = $testResult->testCaseAnswers()->create([
                    'test_case_id'=>$subtaskAnswer['subtaskID'],
                    'userRate'=>$subtaskAnswer['subtaskRating'],
                    'answer'=>$subtaskAnswer['subtaskAnswer']
                ]);
                if(is_null( $testCaseAnswer)){
                    return $this->sendError('this test answer dosen\'t belong to this test result');
                }
            }
            return $this->sendResponse("", 'Test answer created successfully updated successfully.');

        }
    }
    public function addtest(Request $req){
        $validator = Validator::make($req->all(), [
            'taskID' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = auth()->guard('tester')->user();
        $testResult = $user->testResults()->where('test_id',$req->taskID)->get()->first();
        if($testResult){
            return $this->sendResponse("",'you already applied to this test');       
        }
        $user->testResults()->create([
            'videoURL'=>'',
            'test_id'=>$req->taskID,
        ]);
        return $this->sendResponse("", 'Test result created successfully ');
    }
}

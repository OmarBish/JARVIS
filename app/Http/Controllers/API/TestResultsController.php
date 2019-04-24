<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

use App\Tester;
use App\TestResult;
use Auth;
use Validator;

class TestResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * /testResults
     */
    //TODO
    public function __construct(){
        $this->middleware(['auth:tester', 'auth:client','scope:tester,client']);
    }
    public function index(Request $request)
    {
        
        //$user = auth()->user()->tokenCan('tester');
       // dd(auth()->guard('tester')->user());
       $user = auth()->guard('tester')->user();
        $testResutls = $user->testResults()->get();
        return $this->sendResponse($testResutls->toArray(), 'testResutls fetched successfully.');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * POST /testResults
     */

    public function store(Request $request)

    {
        $input = $request->all();

        $validator = Validator::make($input, [
            //TODO set to active_url
            'videoURL' => 'required|url' 
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = auth()->user();
        $testResult = $user->testResults()->create([
            'videoURL' => $input['videoURL'],
            'tester_id' => $user->id
        ]);

        return $this->sendResponse($testResult->toArray(), 'Test created successfully.');        
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * GET /testResults/$id
     */

    public function show($id)

    {
        $user = auth()->user();
        $testResult = $user->testResults()->find($id);
        


        if (is_null($testResult)) {

            return $this->sendError('Test not found or you dont have access to this test');

        }


        return $this->sendResponse($testResult->toArray(), 'Test retrieved successfully.');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * PATCH /testResults/$id
     */

    public function update(Request $request, TestResult $testResult)

    {
        
        
        $input = $request->all();

        
        $validator = Validator::make($input, [

            'videoURL' => 'required|url'  

        ]);



        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $testResult->videoURL =$input['videoURL'];
        

        $testResult->save();


        return $this->sendResponse($testResult->toArray(), 'Test updated successfully.');

    }


    /**

     * Remove the specified resource from storage.
     * @param  int  $id
     * Delete /testResults/$id
     */

    public function destroy(Request $request,TestResult $testResult)
    {
        $user = auth()->user();
        if($user->testResults()->find($testResult->id)){
            $testResult->delete();
            return $this->sendResponse($testResult->toArray(), 'Test deleted successfully.');
        }else{
            return $this->sendError('access error', 'either you dont have access to this record or it was deleted');
        }
        

    }
}

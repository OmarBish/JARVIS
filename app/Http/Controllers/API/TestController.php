<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Test;
use App\Client;

use Validator;

class TestController extends BaseController
{

    public function __construct(){
        $this->middleware(['auth:api','scope:tester,client'])->only(['index']);
        $this->middleware(['auth:api','scope:client'])->only(['store']);
        $this->middleware(['auth:api','scope:client,tester'])->only(['show']);
        $this->middleware(['auth:api','scope:client'])->only(['update']);
        $this->middleware(['auth:api','scope:client'])->only(['destroy']);
    }
    

    public function index(Request $request)
    {   
        $user = auth()->guard('client')->user();
        $tests = $user->tests()->get();
        return $this->sendResponse($tests->toArray(), 'Tests retrieved successfully.');
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $input = $request->all();


        $validator = Validator::make($input, [

            'name' => 'required',

            'websiteURL' => 'required',

            'credit' => 'required',
            'post_url' => 'url',
            'testers' => 'required',

            'tags' => 'required'    
        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $user = auth()->guard('client')->user();
        $test = $user->tests()->create($input);


        return $this->sendResponse($test->toArray(), 'Test created successfully.');

    }
        /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        // if(auth()->user()->tokenCan('tester'))
        //     $user = auth()->guard('tester')->user();
        // else
        //     $user = auth()->guard('client')->user();

        $test =Test::find($id);
        


        if (is_null($test)) {
            return $this->sendError('Test not found or you dont have access to this test');
        }


        return $this->sendResponse($test->toArray(), 'Test retrieved successfully.');

    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Test $test)

    {
        
        $input = $request->all();

        
        $validator = Validator::make($input, [

            'name' => 'required',

            'websiteURL' => 'required',

            'credit' => 'required',

            // 'tags' => 'required' 

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }
       
        $user = auth()->guard('client')->user();

        $test = $user->tests()->find($test->id);
        if (is_null($test)) {
            return $this->sendError('Test not found or you dont have access to this test');
        }

        $test->name = $input['name'];

        $test->websiteURL = $input['websiteURL'];
        $test->credit = $input['credit'];
        if(isset($input['tags'])){
            $test->tags = $input['tags'];
        }
        if(isset($input['pst_url'])){
            $test->tags = $input['post_url'];
        }
        
        $test->save();
        return $this->sendResponse($test->toArray(), 'Test updated successfully.');

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy(Request $req,Test $test)

    {
        $user = auth()->guard('client')->user();
        try{
            if($user->tests()->find($test->id)){
                $test->delete();
                return $this->sendResponse("", 'Test deleted successfully.');
            }else{
                return $this->sendError('access error', 'either you dont have access to this record or it was deleted');
            }
        }catch(Exception $x){
            return $this->sendError('access error', 'either you dont have access to this record or it was deleted');
        }
        
    }
}





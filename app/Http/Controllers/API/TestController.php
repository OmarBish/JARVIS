<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Test;

use Validator;

class TestController extends BaseController
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $tests = Test::all();


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

            'websiteUrl' => 'required',

            'credit' => 'required',

            'tags' => 'required'    
        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $test = Test::create($input);


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

        $test = Test::find($id);


        if (is_null($test)) {

            return $this->sendError('Test not found.');

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

            'websiteUrl' => 'required',

            'credit' => 'required',

            'tags' => 'required' 

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $test->name = $input['name'];

        $test->websiteUrl = $input['websiteUrl'];
        $test->credit = $input['credit'];
        $test->tags = $input['tags'];

        $test->save();


        return $this->sendResponse($test->toArray(), 'Test updated successfully.');

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy(Test $test)

    {

        $test->delete();


        return $this->sendResponse($test->toArray(), 'Test deleted successfully.');

    }
}





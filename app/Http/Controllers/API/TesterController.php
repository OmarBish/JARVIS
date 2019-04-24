<?php

namespace App\Http\Controllers\API;

use App\Tester;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use Validator;


class TesterController extends BaseController
{
    //TODO
    public function __construct(){
        $this->middleware('guest')->only('store');
        $this->middleware('auth:tester')->except('store');
    }
    /**
     * Display a listing of the clients
     *
     * @param  \App\Tester  $model
     * @return \Illuminate\View\View
     */
    public function index(Tester $testers)
    {
        $data = ['testers' => $testers->paginate(15)];
        return $this->sendResponse($data,"Retrive all clients");
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function show(Tester $tester)
    {
        return $this->sendResponse($tester,"Retrive client");
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Tester  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        
        /**
         * 1- check validation
         * 2- check if exist
         * 3- regisiter
         */
        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required',

            'c_password' => 'required|same:password',

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $tester = Tester::where('email',$request->email)->first();
        
        if(isSet($tester)){
            return $this->sendError('Tester already exist', "Tester already exist");       
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $tester = Tester::create($input);

        $success['token'] =  $tester->createToken('MyApp')->accessToken;

        $success['name'] =  $tester->name;


        return $this->sendResponse($tester, 'Tester register successfully.');
    }

    
    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Tester  $tester
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tester  $tester)
    {
        $tester->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));
       
       return  $this->sendResponse($tester,"update client");
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\Tester  $tester
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tester  $tester)
    {
        $tester->delete();

        return  $this->sendResponse("success","tester deleted");
    }
}

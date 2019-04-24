<?php
//App\Http\Controllers\Client\ClientController
namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\AuthController;

use Validator;


class ClientController extends BaseController
{
    //TODO
    public function __construct(){
        $this->middleware('auth:client')->except('store');
        $this->middleware('guest')->only('store');
    }
    /**
     * Display a listing of the clients
     *
     * @param  \App\Client  $model
     * @return \Illuminate\View\View
     */
    public function index(Client $model)
    {
        $data = ['clients' => $model->paginate(15)];
        return $this->sendResponse($data,"Retrive all clients");
    }

    /**
     * Display a listing of the clients
     *
     * @param  \App\Client  $model
     * @return \Illuminate\View\View
     */
    public function show(Client $client)
    {
        return $this->sendResponse($client,"Retrive client");
    }



    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Client  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required',

            'c_password' => 'required|same:password',

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $client = Client::where('email',$request->email)->first();
        
        if(isSet($client)){
            return $this->sendError('Client already exist', "Client already exist");       
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $client = Client::create($input);

        $success['token'] =  $client->createToken('MyApp')->accessToken;

        $success['name'] =  $client->name;


        return $this->sendResponse($client, 'Client register successfully.');

    }


    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Client  $client)
    {
        
         $client->update(
             $request->merge(['password' => Hash::make($request->get('password'))])
                 ->except([$request->get('password') ? '' : 'password']
         ));
        
        return  $this->sendResponse($client,"update client");
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client  $client)
    {
        $client->delete();

        return  $this->sendResponse("success","client deleted");
    }
}

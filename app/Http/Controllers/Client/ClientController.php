<?php

namespace App\Http\Controllers\Client;

use App\Client;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients
     *
     * @param  \App\Client  $model
     * @return \Illuminate\View\View
     */
    public function index(Client $model)
    {
        return view('client.index', ['clients' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Client  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, Client $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        return redirect()->route('client.index')->withStatus(__('Client successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        return view('client.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, Client  $client)
    {
        $client->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('client.index')->withStatus(__('Client successfully updated.'));
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

        return redirect()->route('client.index')->withStatus(__('Client successfully deleted.'));
    }
}

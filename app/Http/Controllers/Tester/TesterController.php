<?php

namespace App\Http\Controllers\Tester;

use App\Tester;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class TesterController extends Controller
{
    /**
     * Display a listing of the clients
     *
     * @param  \App\Tester  $model
     * @return \Illuminate\View\View
     */
    public function index(Tester $model)
    {
        return view('tester.index', ['testers' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('testers.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Tester  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, Tester $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        return redirect()->route('tester.index')->withStatus(__('Tester successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\Tester  $tester
     * @return \Illuminate\View\View
     */
    public function edit(Tester $tester)
    {
        return view('tester.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Tester  $tester
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, Tester  $tester)
    {
        $tester->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('tester.index')->withStatus(__('Tester successfully updated.'));
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

        return redirect()->route('tester.index')->withStatus(__('Tester successfully deleted.'));
    }
}

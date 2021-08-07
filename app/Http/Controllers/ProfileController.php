<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Session;

/**
 * Class ProfileController
 * Controller for handling request regarding the user profile.
 */
class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        Session::flashInput([
            'first_name' => old('type', $user->first_name),
            'last_name' => old('type', $user->last_name),
            'email' => $user->email,
            'phone' => old('type', $user->phone),
        ]);

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'old_password' => 'required_with:new_password,password_confirm|passwords_match:'.$user->getAuthPassword(),
            'new_password' => 'required_with:old_password,password_confirm|same:password_confirm',
        ]);

        if ($request->has('new_password')) {
            $user->password = Hash::make($request->get('new_password'));
        }

        if ($request->has('initial_login')) {
            $user->initial_login = false;
        }

        $user->update($request->only(['first_name', 'last_name', 'phone']));

        return redirect()->action('App\Http\Controllers\ProfileController@show');
    }
}

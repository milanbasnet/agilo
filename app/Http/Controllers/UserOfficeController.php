<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Services\AssetService;
use App\Utils\ImageUtil;
use Auth;
use Illuminate\Http\Request;
use Session;

/**
 * Class UserOfficeController
 * Handles request for office of the currently logged in user.
 * Modifications can only be performed by users in role 'office_admin'.
 */
class UserOfficeController extends Controller
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->middleware('role:office-admin,therapist', ['only' => 'show']);
        $this->middleware('role:office-admin', ['except' => ['show']]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $office = Auth::user()->office;

        return view('user-office.show', compact('office'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $office = Auth::user()->office;

        $this->flash($office);

        return view('user-office.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AssetService $assetService)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'street' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png|max:300',
            'type' => 'required|integer|exists:office_types,id',
            'sports' => 'sports',
            'has_billing_address' => 'boolean',
            'billing_name' => 'required_if:has_billing_address,1',
            'billing_street' => 'required_if:has_billing_address,1',
            'billing_zip_code' => 'required_if:has_billing_address,1',
            'billing_city' => 'required_if:has_billing_address,1',
            'billing_country' => 'required_if:has_billing_address,1',
        ]);

        $office = Auth::user()->office;
        $office->fill($request->input());

        $office->office_type_id = $request->input('type');
        $office->has_billing_address = $request->exists('has_billing_address');

        if ($request->hasFile('image')) {
            $oldImagePath = $office->logo_path;

            $office->logo_path = $assetService->moveAndResizeImage($request->file('image'));

            $assetService->delete($oldImagePath);
        }

        $office->save();

        if ($request->exists('sports')) {
            $office->sports()->sync($request->input('sports'));
        }

        return redirect()->action('App\Http\Controllers\UserOfficeController@show');
    }

    /**
     * Flashes the given office to the session.
     *
     * @param Office $office
     */
    private function flash(Office $office)
    {
        $flash = [
            'name' => old('name', $office->name),
            'contact' => old('contact', $office->contact),
            'street' => old('street', $office->street),
            'zip_code' => old('zip_code', $office->zip_code),
            'city' => old('city', $office->city),
            'country' => old('country', $office->country),
            'phone' => old('phone', $office->phone),
            'email' => old('email', $office->email),
            'logo_path' => old('logo_path', $office->logo_path),
            'type' => old('type', $office->office_type_id),
            'sports' => old('sports', $office->sportIds()),
            'has_billing_address' => old('has_billing_address', $office->has_billing_address),
            'billing_name' => old('billing_name', $office->billing_name),
            'billing_street' => old('billing_street', $office->billing_street),
            'billing_zip_code' => old('billing_zip_code', $office->billing_zip_code),
            'billing_city' => old('billing_city', $office->billing_city),
            'billing_country' => old('billing_country', $office->billing_country)
        ];

        Session::flashInput($flash);
    }
}

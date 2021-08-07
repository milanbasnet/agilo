<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Role;
use App\Services\AssetService;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use App\Services\Mailer;
use Illuminate\Support\MessageBag;
use Log;
use Session;
use Illuminate\Support\Str;

/**
 * Class OfficesController
 * Handles administration of offices, restricted to admins.
 */
class OfficesController extends Controller
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->middleware('hide.admin.office', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $offices = Office::where('id', '!=', Auth::user()->office_id)->get();

        return view('offices.index', compact('offices'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $office = Office::findOrFail($id);

        return view('offices.show', compact('office'));
    }

    public function create()
    {
        return view('offices.create');
    }

    public function store(Request $request, Mailer $mailer, AssetService $assetService)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'street' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
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

        $office = new Office($request->input());

        $office->office_type_id = $request->input('type');
        $office->has_billing_address = $request->exists('has_billing_address');

        if ($request->hasFile('image')) {
            $oldImagePath = $office->logo_path;

            $office->logo_path = $assetService->moveAndResizeImage($request->file('image'));
            $assetService->delete($oldImagePath);
        }

        $role = Role::whereName('office-admin')->first();

        $officeAdmin = new User();
        $officeAdmin->role()->associate($role);
        $officeAdmin->email = $request->input('email');

        $password = Str::random(10);
        $officeAdmin->password = Hash::make($password);

        $names = explode(' ', $request->input('contact'), 2);

        $officeAdmin->first_name = $names[0];
        $officeAdmin->last_name = count($names) > 1 ? $names[1] : '';
        $officeAdmin->phone = $office->phone;
        $officeAdmin->language_code='de';

        try {
            DB::transaction(function () use ($request, $office, $officeAdmin) {
                $office->save();

                if ($request->exists('sports')) {
                    $office->sports()->sync($request->input('sports'));
                }

                $officeAdmin->office()->associate($office);
                $officeAdmin->save();
            });
        } catch (\Exception $e) {
            Log::error($e->__toString());
            $errors = new MessageBag();
            $errors->add('Unerwarteter Fehler', 'Es ist ein unerwateter Fehler aufgetreten.');
            return redirect()->action('App\Http\Controllers\OfficesController@index')->withErrors($errors);
        }

        $mailer->send('office-admin-created',
            ['officeAdmin' => $officeAdmin, 'password' => $password],
            function ($message) use ($officeAdmin) {
                $message->to($officeAdmin->email)->subject(trans('subjects.office-admin-created'));
            }
        );

        return redirect()->action('App\Http\Controllers\OfficesController@show', [$office->id]);
    }

    public function activate($id)
    {
        if (Auth::user()->office_id == $id) {
            return redirect()->action('App\Http\Controllers\OfficesController@index');
        }

        $office = Office::findOrFail($id);
        $office->active = true;
        $office->save();

        return redirect()->action('App\Http\Controllers\OfficesController@show', [ $office->id ]);
    }

    public function deactivate($id)
    {
        if (Auth::user()->office_id == $id) {
            return redirect()->action('App\Http\Controllers\OfficesController@index');
        }

        $office = Office::findOrFail($id);
        $office->active = false;
        $office->save();

        return redirect()->action('App\Http\Controllers\OfficesController@show', [ $office->id ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\Mailer;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TherapistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:office-admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $therapists = User::whereOfficeId(Auth::user()->office_id)
            ->where('id', '!=', Auth::user()->id)
            ->with('groups')
            ->get();

        return view('therapists.index', compact('therapists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('therapists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request, Mailer $mailer)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'role' => 'required|integer|exists:therapist_roles,id',
        ]);

        $therapist = new User();
        $therapist->first_name=$request->first_name;
        $therapist->last_name=$request->last_name;
        $therapist->email=$request->email;
        $therapist->phone=$request->phone;




        $password = Str::random(10);
        $therapist->password = Hash::make($password);

        $therapist->language_code = Auth::user()->language_code;
        $therapist->office_id = Auth::user()->office_id;
        $therapist->role()->associate(Role::whereName('therapist')->firstOrFail());
        $therapist->therapist_role_id = $request->input('role');

        $therapist->save();

        $mailer->send('therapist-created',
            ['therapist' => $therapist, 'password' => $password],
            function ($message) use ($therapist) {
                $message->to($therapist->email)->subject(trans('subjects.therapist-created'));
            }
        );

        return redirect()->action('App\Http\Controllers\TherapistsController@show', [$therapist->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $therapist = $this->find($id);

        return view('therapists.show', compact('therapist'));
    }

    public function activate($id)
    {
        $therapist = $this->find($id);
        $therapist->active = true;
        $therapist->save();

        return redirect()->action('App\Http\Controllers\TherapistsController@show', [ $therapist->id ]);
    }

    public function deactivate($id)
    {
        $therapist = $this->find($id);
        $therapist->active = false;
        $therapist->save();

        return redirect()->action('App\Http\Controllers\TherapistsController@show', [ $therapist->id ]);
    }

    private function find($id) {
        return User::whereOfficeId(Auth::user()->office_id)
            ->where('id', '!=', Auth::user()->id)
            ->findOrFail($id);
    }
}

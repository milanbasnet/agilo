<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Services\Mailer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use validator;

class AthletesPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('athletes.auth.reset-email');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mailer $mailer)
    {
        //
        $this->validate($request, [
            'email' => 'required|email|exists:athletes',

        ]);

        try {
            DB::beginTransaction();
            $athlete = Athlete::where('email', $request->email)->first();

            $recoveryCode = Str::random(6);

            $athlete->recovery_code = $recoveryCode;

            $athlete->update();

            $mailer->send('athlete-password-recovery',
                ['code' => $recoveryCode, 'email' => $athlete->email],
                function ($message) use ($athlete) {
                    $message->to($athlete->email)->subject(trans('subjects.password-reset-code'));
                }
            );

            DB::commit();

            return $this->edit($athlete, trans('messages.athletes-password-reset'));

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', trans('messages.error-cooured'));

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Athlete $athlete, $message)
    {
        //
        return view('athletes.auth.reset-password', compact('athlete'))->with('success', $message);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        //

        $athlete = Athlete::where('email', $email)->first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:athletes',
            'code' => 'required',
            'password' => 'required|confirmed|min:6',

        ]);

        if ($validator->fails()) {
            return $this->edit($athlete, '')->withErrors($validator->errors());
        }

        if ($athlete->recovery_code != $request->code) {
            return $this->edit($athlete, '')->withErrors(trans('messages.please-enter-valid-reset-code'));

        }

        $athlete->password = Hash::make($request->password);
        $athlete->recovery_code = null;

        $athlete->update();

        return view('athletes.auth.success-page');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

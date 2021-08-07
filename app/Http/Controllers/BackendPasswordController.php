<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Mailer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use validator;
class BackendPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('auth.backend.reset_password');
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
    public function store(Request $request,Mailer $mailer)
    {
        //
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();

            $recovery_code = Str::random(6);



            $user-> recovery_code = $recovery_code;

            $user->update();

            $mailer->send('backend-password-recovery',
            ['code' => $recovery_code,'email'=>$user->email],
            function ($message) use ($user) {
                $message->to($user->email)->subject(trans('subjects.password-reset-code'));
            }
            );

            DB::commit();

            return  $this->edit($user,trans('messages.backend-password-reset'));

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
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
    public function edit(User $user,$message)
    {
        //
        return view('auth.backend.reset_form',compact('user'))->with('success',$message);

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
        $user = User::where('email',$email)->first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password'=>'required|confirmed|min:6',

          ]);

        if ($validator->fails()) {
         return $this->edit($user,'')->withErrors($validator->errors());
      }



      if($user->recovery_code != $request->code)
      {
         return $this->edit($user,'')->withErrors(trans('messages.please-enter-valid-reset-code'));


      }

      $user->password = Hash::make($request->password);
      $user->recovery_code = null;

      $user->update();


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

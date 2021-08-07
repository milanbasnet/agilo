<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;


class TestController extends Controller
{
    //


    public function testMail(Request $request)
    {

      if(empty($request->email))
     {
        abort(401);
        return;
     }
        try{
        Mail::raw('Hi, welcome user!', function ($message) use($request){
            $message->to($request->email)
              ->subject('This Is Test Mail');
              ;
          });
          echo 'Sent to : '.$request->email;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    
    }
}

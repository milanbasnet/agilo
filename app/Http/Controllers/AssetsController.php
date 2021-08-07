<?php

namespace App\Http\Controllers;

use Storage;

class AssetsController extends Controller
{
    public function show($name)
    {
        if (!Storage::exists($name)) {
            abort(404);
        }

        return response()->file(storage_path('/app/public/'.$name));
    }
}

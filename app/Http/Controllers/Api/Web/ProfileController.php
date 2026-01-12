<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function index()
    {
        return view('web.profile.index');
    }
}

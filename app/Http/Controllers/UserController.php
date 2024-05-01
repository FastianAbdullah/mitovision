<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    public function setApikey(Request $request){
        $user = new User(Config::get('services.stripe.sk'));
        dd($user);
    }
}

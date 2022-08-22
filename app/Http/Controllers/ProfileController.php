<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Shows user's profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        return view('home', [
            'user' => $user,
        ]);
    }
}

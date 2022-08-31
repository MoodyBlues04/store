<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Stores profile's rating
     */
    public function store(User $user)
    {
        // TODO переделать на передачу profile->id в request, чтобы соотв http-controllers и не было аргументов
        return auth()->user()->rated()->create([
            'profile_id' => $user->profile->id,
            'value' => request('value'),
        ]);
    }
}

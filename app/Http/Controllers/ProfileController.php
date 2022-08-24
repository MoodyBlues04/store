<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Shows user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        return view('home', [
            'user' => $user,
        ]);
    }

    /**
     * Edits user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        return view('edit', [
            'user' => $user,
        ]);
    }
}

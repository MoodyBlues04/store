<?php

namespace App\Http\Controllers;

use App\Models\User;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    /**
     * Shows user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        return view('profile.index', [
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
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Stores new product into the DB
     */
    public function store()
    {
        $data = request()->validate([
            'username' => ['required', 'string', 'max:20'],
            'introduction' => ['required', 'string', 'max:500'],
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('images', 'public');

        $image = Image::make(public_path('storage/' . $imagePath))->resize(200, 200);
        $image->save();

        if (!isset(auth()->user()->profile)) {
            auth()->user()->profile()->create([
                'username' => $data['username'],
                'introduction' => $data['introduction'],
                'image' => $imagePath,
            ]);
        } else {
            $profile = auth()->user()->profile;
            $profile->username = $data['username'];
            $profile->introduction = $data['introduction'];
            $profile->image = $imagePath;
            $profile->save();
        }
        

        return redirect('/profile/' . auth()->user()->id);
    }
}

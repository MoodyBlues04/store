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
        return view('profile.index', compact('user'));
    }

    /**
     * Edits user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    /**
     * Validation rules for Profile model
     * @var array<string,string[]> $valdationRules field => rules
     */
    protected $validationRules = [
        'username' => ['required', 'string', 'max:20'],
        'introduction' => ['required', 'string', 'max:500'],
        'image' => ['image', 'mimes:jpg,jpeg,png'],
    ];

    /**
     * Updates profile's data
     * @param User $user
     */
    public function update(User $user)
    {
        $data = request()->validate($this->validationRules);
        $user->profile()->update($data);

        return redirect("/profile/{$user->id}");
    }

    /**
     * Stores new product into the DB
     */
    public function store()
    {
        $data = request()->validate($this->validationRules);

        if (request('image') !== null) {
            $imagePath = request('image')->store('images', 'public');

            $image = Image::make(public_path('storage/' . $imagePath))->resize(200, 200);
            $image->save();
        } else {
            $imagePath = null;
        }
        
        auth()->user()->profile()->create([
            'username' => $data['username'],
            'introduction' => $data['introduction'],
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }
}

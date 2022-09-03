<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use App\Repository\RatingRepository;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    private RatingRepository $ratingRepository;

    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Shows user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        $avgValue = $this->ratingRepository->getAvgValueByProfileId($user->profile->id);

        if (auth()->user() === null) {
            return view('profile.show', compact('user', 'avgValue'));
        }

        $rating = $this->ratingRepository->getRatingByUserAndProfile(auth()->user()->id, $user->profile_id);
        $value = $rating->value ?? false; 
        
        return view('profile.show', compact('user', 'value', 'avgValue'));
    }

    /**
     * Edits user's profile
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
    }

    /**
     * Updates profile's data
     * @param User $user
     */
    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([ // TODO перенести подобную валидацию в
            'username' => ['nullable', 'string', 'max:20'],
            'introduction' => ['nullable', 'string', 'max:500'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'nullable']
        ]);

        $imagePath = $user->profile->image;
        if (request('image') !== null) {
            $imagePath = $this->storeProfileImage(request('image'));
            $user->profile->removeImage();
        }

        $profile = auth()->user()->profile;
        $profile->username = $data['username'] ?? $profile->username;
        $profile->introduction = $data['introduction'] ?? $profile->introduction;
        $profile->image = $imagePath;

        if (!$profile->save()) {
            throw new \Exception("Profile not saved");
        }

        return redirect("/profile/{$user->id}");
    }

    /**
     * Stores new product into the DB
     */
    public function store()
    {
        $data = request()->validate([
            'username' => ['required', 'string', 'max:20'],
            'introduction' => ['required', 'string', 'max:500'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'nullable']
        ]);

        $imagePath = null;
        if (request('image') !== null) {
            $imagePath = $this->storeProfileImage(request('image'));
        }
        
        auth()->user()->profile()->create([
            'username' => $data['username'],
            'introduction' => $data['introduction'],
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }
}

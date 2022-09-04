<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Rating;
use App\Models\User;
use App\Repository\ProfileRepository;
use App\Repository\RatingRepository;


class ProfileController extends Controller
{
    private RatingRepository $ratingRepository;

    private ProfileRepository $profileRepository;

    public function __construct(
        RatingRepository $ratingRepository,
        ProfileRepository $profileRepository
    ) {
        $this->ratingRepository = $ratingRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * Shows user's profile
     */
    public function show(User $user)
    {
        $rawAvgValue = $this->ratingRepository->getAvgValueByProfileId($user->profile->id);
        $avgValue = $rawAvgValue ?? 'N/A';

        if (auth()->user() === null) {
            return view('profile.show', compact('user', 'avgValue'));
        }

        $rating = $this->ratingRepository->getRatingByUserAndProfile(auth()->user()->id, $user->profile->id);
        $value = $rating->value ?? false; 

        return view('profile.show', compact('user', 'value', 'avgValue'));
    }

    /**
     * Edits user's profile
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
    }

    /**
     * Updates profile's data
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user->profile);

        $imagePath = $user->profile->image;
        if (request('image') !== null) {
            $imagePath = ImageHelper::storeProfileImage(request('image'));
            $this->profileRepository->removeImageById($user->profile->id);
        }

        $profile = auth()->user()->profile;
        $profile->username = $request['username'] ?? $profile->username;
        $profile->introduction = $request['introduction'] ?? $profile->introduction;
        $profile->image = $imagePath;

        if (!$profile->save()) {
            throw new \Exception("Profile not saved");
        }

        return redirect("/profile/{$user->id}");
    }

    /**
     * Stores new product into the DB
     */
    public function store(ProfileStoreRequest $request)
    {
        $imagePath = null;
        if (request('image') !== null) {
            $imagePath = ImageHelper::storeProfileImage(request('image'));
        }
        
        auth()->user()->profile()->create([
            'username' => $request['username'],
            'introduction' => $request['introduction'],
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }
}

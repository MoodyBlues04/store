<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CustomResponse;
use App\Exceptions\InternalServerException;
use App\Helpers\ImageHelper;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Rating;
use App\Models\User;
use App\Repository\ProfileRepository;
use App\Repository\RatingRepository;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
        $productsCount = Cache::remember(
            'count.product' . (string)$user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->products->count();
            }
        );

        $rawAvgValue = $this->ratingRepository->getAvgValueByProfileId($user->profile->id);
        $avgValue = $rawAvgValue ?? 'N/A';

        if (auth()->user() === null) {
            return view('profile.show', compact('user', 'avgValue', 'productsCount'));
        }

        $rating = $this->ratingRepository->getRatingByUserAndProfile(auth()->user()->id, $user->profile->id);
        $value = $rating->value ?? false; 

        return view('profile.show', compact('user', 'value', 'avgValue', 'productsCount'));
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
        if ($request->getImage() !== null) {
            $imagePath = ImageHelper::storeProfileImage($request->getImage());
            $this->profileRepository->removeImageById($user->profile->id);
        }

        $profile = auth()->user()->profile;
        $profile->username = $request->username ?? $profile->username;
        $profile->introduction = $request->introduction ?? $profile->introduction;
        $profile->image = $imagePath;

        if (!$this->profileRepository->save($profile)) {
            throw new InternalServerException(
                "Profile not saved",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                CustomResponse::INTERNAL_SERVER_ERROR
            );
        }

        return redirect("/profile/{$user->id}");
    }

    /**
     * Stores new product into the DB
     */
    public function store(ProfileStoreRequest $request)
    {
        $imagePath = null;
        if ($request->getImage() !== null) {
            $imagePath = ImageHelper::storeProfileImage($request->getImage());
        }
        
        auth()->user()->profile()->create([
            'username' => $request->username,
            'introduction' => $request->introduction,
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }
}

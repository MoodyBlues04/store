<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingStoreRequest;
use App\Models\Rating;
use App\Models\User;
use App\Repository\RatingRepository;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    private RatingRepository $ratingRepository;

    public function __construct(RatingRepository $ratingRepository)
    {
        $this->middleware('auth');
        
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Stores profile's rating
     * @throws \Exception
     */
    public function store(RatingStoreRequest $request)
    {
        $userId = auth()->user()->id;
        $value = $request['value'];
        $user = $request->getUserModel();
        $profileId = $user->profile->id;

        $rating = $this->ratingRepository->getRatingByUserAndProfile($userId, $profileId);
        if (isset($rating->value)) {
            $rating->delete();
        }
        
        if ($value === -1) {
            $avgValue = $this->ratingRepository->getAvgValueByProfileId($profileId);
            return [false, $avgValue];
        }
        

        $rating = new Rating();
        $rating->user_id = $userId;
        $rating->profile_id = $profileId;
        $rating->value = $value;
        
        if (!$rating->save()) {
            throw new \Exception("Rating not saved");
        }

        $avgValue = $this->ratingRepository->getAvgValueByProfileId($profileId);
        
        return [$value, $avgValue];
    }
}

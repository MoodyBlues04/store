<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CustomResponse;
use App\Exceptions\InternalServerException;
use App\Http\Requests\RatingStoreRequest;
use App\Models\Rating;
use App\Models\User;
use App\Repository\RatingRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $value = $request->value;
        $user = $request->getUserModel();
        $profileId = $user->profile->id;

        $rating = $this->ratingRepository->getRatingByUserAndProfile($userId, $profileId);
        if (isset($rating->value)) {
            $this->ratingRepository->delete($rating);
        }
        
        if ($value === -1) {
            $avgValue = $this->ratingRepository->getAvgValueByProfileId($profileId);
            return [false, $avgValue ?? 'N/A'];
        }
        

        $rating = new Rating();
        $rating->user_id = $userId;
        $rating->profile_id = $profileId;
        $rating->value = $value;
        
        if (!$this->ratingRepository->save($rating)) {
            throw new InternalServerException(
                "Rating not saved",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                CustomResponse::INTERNAL_SERVER_ERROR
            );
        }

        $avgValue = $this->ratingRepository->getAvgValueByProfileId($profileId);
        
        return [$value, $avgValue];
    }
}

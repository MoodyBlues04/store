<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Rating;

class RatingRepository
{
    /**
     * Gets profile's avg rating
     * @param int $profileId
     * @return float|null
     */
    public function getAvgValueByProfileId(int $profileId): ?float
    {
        $ratings = Rating::where('profile_id', $profileId)->get();
        $sum = $ratings->sum('value');
        $count = $ratings->count();
        
        if ($count === 0) {
            return null;
        }
        return $sum / $count; 
    }

    public function getRatingByUserAndProfile(int $userId, int $profileId): ?Rating
    {
        $rating = Rating::where('user_id', $userId)
            ->where('profile_id', $profileId)
            ->first();

        return $rating;
    }
}
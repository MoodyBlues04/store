<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Stores profile's rating
     * @throws \Exception
     */
    public function store()
    {
        if (request('user') === null) {
            throw new \Exception("Unset user error");
        }
        $value = request('value');
        $user = User::findOrFail(request('user'));

        $userId = auth()->user()->id;
        $profileId = $user->profile->id;

        $rating = Rating::where('user_id', auth()->user()->id)
            ->where('profile_id', $profileId)
            ->first();
        
        if (isset($rating->value)) {
            $rating->delete();
        }
        
        if ($value === -1) {
            $avgValue = Rating::getAvgValueByProfileId($profileId);
            return [false, $avgValue];
        }
        

        $rating = new Rating();
        $rating->user_id = $userId;
        $rating->profile_id = $profileId;
        $rating->value = $value;
        
        if (!$rating->save()) {
            throw new \Exception("Rating not saved");
        }

        $avgValue = Rating::getAvgValueByProfileId($profileId);
        
        return [$value, $avgValue];
    }
}

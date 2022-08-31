<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Stores profile's rating
     * @throws \Exception
     */
    public function store()
    {
        if (request('user') === null) {
            throw new \Exception("Unset user error");
        }
        if (request('value') === null) {
            throw new \Exception("Unset value error");
        }
        
        $user = User::findOrFail(request('user'));
        
        $rating = new Rating();
        $rating->user_id = auth()->user()->id;
        $rating->profile_id = $user->profile->id;
        $rating->value = request('value');
        
        if (!$rating->save()) {
            throw new \Exception("Rating not saved");
        }
        
        return ["successfully created $rating->id"];
    }
}

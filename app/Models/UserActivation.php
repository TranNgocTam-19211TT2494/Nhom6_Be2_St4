<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserActivation extends Model
{
    //
    protected $table = 'user_activations';

    protected function getToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    public function createActivation($user)
    {

        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);
    }

    private function regenerateToken($user)
    {

        $token = $this->getToken();
        UserActivation::where('user_id', $user->id)->update([
            'activation_code' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    private function createToken($user)
    {
        $token = $this->getToken();
        UserActivation::insert([
            'user_id' => $user->id,
            'activation_code' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    public function getActivation($user)
    {
        return UserActivation::where('user_id', $user->id)->first();
    }

    public function getActivationByToken($token)
    {
        return UserActivation::where('activation_code', $token)->first();
    }

    public function deleteActivation($token)
    {
        UserActivation::where('activation_code', $token)->delete();
    }
}

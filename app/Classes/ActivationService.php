<?php

namespace App\Classes;

use Illuminate\Support\Facades\Mail;
use App\Models\UserActivation;
use App\Mail\UserActivationEmail;
use App\User;

class ActivationService
{
    protected $resendAfter = 24; // Sẽ gửi lại mã xác thực sau 24h nếu thực hiện sendActivationMail()
    protected $userActivation;

    public function __construct(UserActivation $userActivation)
    {
        $this->userActivation = $userActivation;
    }

    public function sendActivationMail($user)
    {
        if ($user->activated || !$this->shouldSend($user)) return;
        $token = $this->userActivation->createActivation($user);
        $user->activation_link = route('user.activate', $token);
        $mailable = new UserActivationEmail($user);
        Mail::to($user->email)->send($mailable);
    }

    public function activateUser($token)
    {
        $activation = $this->userActivation->getActivationByToken($token);
        if ($activation === null) return null;
        $user = User::find($activation->user_id);
        $user->status = "active";
        $user->save();
        $this->userActivation->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user)
    {
        $activation = $this->userActivation->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}

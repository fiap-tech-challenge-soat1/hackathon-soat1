<?php

namespace Modules\User\UseCases;

use Laravel\Sanctum\PersonalAccessToken;

class RevokeToken
{
    public function handle(string $accessToken)
    {
        $token = PersonalAccessToken::findToken($accessToken);

        $token?->delete();
    }
}

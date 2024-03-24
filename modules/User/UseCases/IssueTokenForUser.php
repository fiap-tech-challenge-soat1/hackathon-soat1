<?php

namespace Modules\User\UseCases;

use Laravel\Sanctum\NewAccessToken;
use Modules\User\Entities\User;

class IssueTokenForUser
{
    public function handle(User $user): NewAccessToken
    {
        return $user->createToken(sprintf(
            'Created at %s', now()->toDateString(),
        ));
    }
}

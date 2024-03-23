<?php

namespace Modules\User\UseCases;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Entities\User;

class AuthenticateUser
{
    public function handle(array $input): User
    {
        $input = validator($input, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        $user = User::query()->where('email', $input['email'])->first();

        if (! $user || ! Hash::check($input['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email ou senha inválidos.'],
            ]);
        }

        return $user;
    }
}

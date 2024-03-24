<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Modules\User\UseCases\AuthenticateUser;
use Modules\User\UseCases\IssueTokenForUser;
use Modules\User\UseCases\RevokeToken;

class TokensController extends Controller
{
    /**
     * Criar token.
     *
     * @unauthenticated
     *
     * @bodyParam email string required O email do usuário.
     * @bodyParam password string required A senha do usuário (em plaintext para autenticar)
     */
    public function store(Request $request, AuthenticateUser $auth, IssueTokenForUser $tokenCreator)
    {
        $user = $auth->handle($request->all());
        $token = $tokenCreator->handle($user);

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => UserResource::make($user),
        ]);
    }

    /**
     * Revoga o token atual.
     */
    public function destroy(Request $request, RevokeToken $revoker)
    {
        $revoker->handle($request->bearerToken());

        return response()->noContent();
    }
}

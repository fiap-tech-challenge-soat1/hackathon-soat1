<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Ver usuário atual.
     *
     * @apiResource \App\Http\Resources\UserResource
     * @apiResourceModel \App\Models\User
     */
    public function show(Request $request)
    {
        return UserResource::make($request->user());
    }
}

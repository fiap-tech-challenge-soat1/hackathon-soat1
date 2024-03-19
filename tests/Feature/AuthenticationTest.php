<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('issues a token', function () {
    $user = User::factory()->create([
        'email' => 'testing@example.com',
    ]);

    $response = $this->post(route('api.login'), [
        'email' => $user->email,
        'password' => 'password', // the default password for testing...
    ])->assertOk()->assertJsonStructure([
        'token',
        'user' => ['id', 'name', 'email'],
    ]);

    $this->withToken($response->json('token'))
        ->get(route('api.user'))
        ->assertOk()
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('requires authentication', function () {
    $this
        ->withHeader('Accept', 'application/json')
        ->get(route('api.user'))
        ->assertUnauthorized();
});

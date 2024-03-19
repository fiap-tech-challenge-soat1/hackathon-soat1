<?php

use App\Models\User;

it('issues a token', function () {
    $user = User::factory()->create([
        'email' => 'testing@example.com',
    ]);

    $response = $this->postJson(route('api.login'), [
        'email' => $user->email,
        'password' => 'password', // the default password for testing...
    ])->assertOk()->assertJsonStructure([
        'token',
        'user' => ['id', 'name', 'email'],
    ]);

    $this->withToken($token = $response->json('token'))
        ->getJson(route('api.user'))
        ->assertOk()
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('validates', function ($input, $expectedErrors) {
    $this->postJson(route('api.login'), value($input))
        ->assertInvalid($expectedErrors);
})->with([
    'required fields' => [
        'input' => [
            'email' => '',
            'password' => '',
        ],
        'errors' => ['email', 'password'],
    ],
    'invalid emails' => [
        'input' => [
            'email' => 'not-valid',
        ],
        'errors' => ['email'],
    ],
    'invalid password' => [
        'input' => fn () => [
            'email' => User::factory()->create()->email,
            'password' => 'invalid',
        ],
        'errors' => ['email'],
    ],
]);

it('requires authentication', function () {
    $this
        ->withHeader('Accept', 'application/json')
        ->getJson(route('api.user'))
        ->assertUnauthorized();
});

it('destroyes tokens', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Testing')->plainTextToken;

    $this->withToken($token)
        ->deleteJson(route('api.logout'))
        ->assertNoContent();

    $this->assertCount(0, $user->refresh()->tokens);
});

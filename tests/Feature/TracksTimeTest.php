<?php

use App\Models\TimeEntry;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('starts a timer', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    $this->freezeTime();

    $this->postJson(route('time-entries.store'))
        ->assertCreated()
        ->assertJsonStructure([
            'data' => ['id', 'started_at', 'ended_at'],
        ]);

    $this->assertCount(1, $entries = $user->refresh()->entries);
    $this->assertTrue($entries->first()->started_at->is(now()));
    $this->assertNull($entries->first()->ends_at);
});

it('can stop a timer', function () {
    $entry = TimeEntry::factory()->create([
        'started_at' => now()->subHour(),
        'ended_at' => null,
    ]);

    Sanctum::actingAs($entry->user, ['*']);

    $this->freezeTime();

    $this->putJson(route('time-entries.update', $entry))
        ->assertOk()
        ->assertJsonStructure([
            'data' => ['id', 'started_at', 'ended_at'],
        ]);

    $this->assertNotNull($entry->refresh()->ended_at);
    $this->assertTrue($entry->ended_at->is(now()));
});

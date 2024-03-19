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

it('only the time entry owner can update the entry', function () {
    $entry = TimeEntry::factory()->create([
        'started_at' => now()->subHour(),
        'ended_at' => null,
    ]);

    Sanctum::actingAs(User::factory()->create(), ['*']);

    $this->putJson(route('time-entries.update', $entry))
        ->assertForbidden();

    $this->assertNull($entry->refresh()->ended_at);
});

it('lists entries', function () {
    $user = User::factory()
        ->has(TimeEntry::factory()->times(3), 'entries')
        ->create();

    Sanctum::actingAs($user, ['*']);

    $this->getJson(route('time-entries.index'))
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

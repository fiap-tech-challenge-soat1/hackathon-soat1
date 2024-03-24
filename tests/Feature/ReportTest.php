<?php

use App\Mail\MonthReport;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Modules\Timekeeping\Entities\TimeEntry;
use Modules\User\Entities\User;

it('requests report', function () {
    Mail::fake();

    $this->freezeTime();

    $user = User::factory()
        ->has(TimeEntry::factory()->times(3)->state([
            'started_at' => now()->subMonth()->startOfMonth()->addDay()->startOfDay(),
            'ended_at' => now()->subMonth()->startOfMonth()->addDay()->startOfDay()->addHour(),
        ]), 'entries')
        // Shouldn't include this...
        ->has(TimeEntry::factory([
            'ended_at' => null,
        ]), 'entries')
        ->create();

    Sanctum::actingAs($user, ['*']);

    $this->postJson(route('reports.store'), [
        'reference' => $reference = now()->subMonth()->startOfMonth()->addDay()->startOfDay()->toDateString(),
    ])->assertAccepted();

    Mail::assertQueued(function (MonthReport $mail) use ($reference, $user) {
        $mail->assertSeeInHtml('Relatório do Mês');
        $mail->assertSeeInHtml('Total: 3h');

        return $mail->reference->is($reference) && $mail->user->is($user);
    });
});

it('requests report (for current month - without reference date)', function () {
    Mail::fake();

    $this->freezeTime();

    $user = User::factory()
        ->has(TimeEntry::factory()->times(3)->state([
            'started_at' => now()->startOfDay(),
            'ended_at' => now()->startOfDay()->addHour(),
        ]), 'entries')
        // Shouldn't include this...
        ->has(TimeEntry::factory([
            'ended_at' => null,
        ]), 'entries')
        ->create();

    Sanctum::actingAs($user, ['*']);

    $this->postJson(route('reports.store'))->assertAccepted();

    Mail::assertQueued(function (MonthReport $mail) use ($user) {
        $mail->assertSeeInHtml('Relatório do Mês');
        $mail->assertSeeInHtml('Total: 3h');

        return $mail->reference->is(now()) && $mail->user->is($user);
    });
});

it('sends empty report', function () {
    Mail::fake();

    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    $this->postJson(route('reports.store'), [
        'reference' => $reference = now()->subMonth()->startOfMonth()->addDay()->startOfDay()->toDateString(),
    ])->assertAccepted();

    Mail::assertQueued(function (MonthReport $mail) use ($reference, $user) {
        $mail->assertSeeInHtml('Relatório do Mês');
        $mail->assertSeeInHtml('Não há entradas');

        return $mail->reference->is($reference) && $mail->user->is($user);
    });
});

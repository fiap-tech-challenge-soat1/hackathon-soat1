<?php

use App\Mail\MonthReport;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;

it('requests report', function () {
    Mail::fake();

    $user = User::factory()
        ->has(TimeEntry::factory()->times(3)->state([
            'started_at' => now()->subMonth()->startOfMonth()->addDay()->startOfDay(),
            'ended_at' => now()->subMonth()->startOfMonth()->addDay()->startOfDay()->addHour(),
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

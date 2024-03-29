<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Modules\Timekeeping\Entities\TimeEntry;
use Modules\User\Entities\User;

class MonthReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Carbon $reference, public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Relatório',
        );
    }

    public function content(): Content
    {
        $entries = $this->user->entries()
            ->where('started_at', '>=', $start = $this->reference->copy()->startOfMonth()->startOfDay())
            ->where('ended_at', '<=', $end = $this->reference->copy()->endOfMonth()->endOfDay())
            ->whereNotNull('ended_at')
            ->get();

        if ($entries->isEmpty()) {
            return new Content(
                markdown: 'mail.empty-month-report',
                with: [
                    'start' => $start,
                    'end' => $end,
                ],
            );
        }

        return new Content(
            markdown: 'mail.month-report',
            with: [
                'entries' => $entries,
                'start' => $start,
                'end' => $end,
                'total' => $this->total($entries),
            ],
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection<array-key, \Modules\Timekeeping\Entities\TimeEntry> $entries
     */
    private function total(Collection $entries): string
    {
        $start = $entries->first()?->started_at ?? now();
        $end = $entries->first()?->ended_at ?? now();

        $entries->skip(1)->each(function (TimeEntry $entry) use (&$end) {
            $end = $end->copy()->add($entry->started_at->diffAsCarbonInterval($entry->ended_at));
        });

        return $start->shortAbsoluteDiffForHumans($end);
    }
}

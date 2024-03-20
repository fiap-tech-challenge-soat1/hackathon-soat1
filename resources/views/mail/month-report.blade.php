<x-mail::message>

# Relatório do Mês

As entradas são do período entre {{ $start->toDateString() }} até  {{ $end->toDateString() }}:

<x-mail::table>
| Inicio  | Fim  | Tempo  |
| ----------- |:-----:| --------:|
@foreach ($entries as $entry)
| {{ $entry->started_at->toDateTimeString() }} | {{ $entry->ended_at->toDateTimeString() }} | {{ $entry->started_at->shortAbsoluteDiffForHumans($entry->ended_at) }} |
@endforeach
| &nbsp; | &nbsp; | **Total: {{ $total }}** |
</x-mail::table>

</x-mail::message>

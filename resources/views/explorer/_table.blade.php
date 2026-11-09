<table>
    <tr><th>Title</th><th>Venue</th><th>Participants</th></tr>
    @foreach ($events as $event)
        <tr>
            <td>{{ $event->title }}</td>
            <td>{{ $event->venue?->name }}</td>
            <td>{{ $event->participants_count }}</td>
        </tr>
    @endforeach
</table>
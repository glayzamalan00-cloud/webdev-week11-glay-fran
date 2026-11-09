@extends('explorer.layout')
@section('title', 'Events (naive: lazy loading)')
@section('content')
    <table>
        <tr><th>Title</th><th>Venue</th><th>Participants</th></tr>
        @foreach ($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->venue->name }}</td>
                <td>{{ $event->participants->count() }}</td>
            </tr>
        @endforeach
    </table>
@endsection
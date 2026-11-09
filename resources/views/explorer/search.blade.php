@extends('explorer.layout')
@section('title', 'Full-text search')
@section('content')
    <form method="GET" action="/events/search">
        <input type="text" name="q" value="{{ $q }}" placeholder="try: lantern">
        <button type="submit">Search</button>
    </form>

    @if ($sql)
        <h3>SQL from Laravel</h3>
        <code>{{ $sql }}</code>
        <code>Bindings: {{ json_encode($bindings) }}</code>
        <p>Showing {{ $events->count() }} result(s) (max 50)</p>
        @include('explorer._table')
    @endif
@endsection
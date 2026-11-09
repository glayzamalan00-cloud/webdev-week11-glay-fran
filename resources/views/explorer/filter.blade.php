@extends('explorer.layout')
@section('title', 'Filter: details dress_code = ' . $code)
@section('content')
    <h3>Arrow form: where('details->dress_code', ...)</h3>
    <code>{{ $arrowSql }}</code>
    <code>Bindings: {{ json_encode($arrowBindings) }}</code>
    <p>Matches: {{ $arrowCount }}</p>

    <h3>whereJsonContains on the whole column</h3>
    <code>{{ $containsSql }}</code>
    <code>Bindings: {{ json_encode($containsBindings) }}</code>
    <p>Matches: {{ $containsCount }}</p>

    <h3>First 50 results</h3>
    @include('explorer._table')
@endsection
@extends('temp-layout')

@section('content')
        <h4>{{ $owner }}</h4>
        @foreach($repos as $repo)
            <div><a href="{{ route('release.index', [$repo->owner, $repo->repository]) }}">{{ $repo->name }}</a></div>
        @endforeach
@endsection

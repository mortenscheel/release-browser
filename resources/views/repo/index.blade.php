@extends('temp-layout')

@section('content')
    @foreach($repos as $owner => $owner_repos)
        <h4><a href="{{ route('repo.owner', compact('owner')) }}">{{ $owner }}</a></h4>
        @foreach($owner_repos as $owner_repo)
            <div><a href="{{ route('release.index', [$owner_repo->owner, $owner_repo->repository]) }}">{{ $owner_repo->name }}</a></div>
        @endforeach
    @endforeach
@endsection

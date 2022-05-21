@extends('temp-layout')

@section('content')
    <h1>{{ $repo->name }}</h1>
    @foreach($repo->releases as $release)
        <div>
            <h2>{{ $release->version }}</h2>
            <div>
                {{ \Illuminate\Mail\Markdown::parse($release->body) }}
            </div>
        </div>
    @endforeach
@endsection

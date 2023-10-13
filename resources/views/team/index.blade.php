<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>KP陸戰隊::志工團</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
    
        <div id="app">
            <main class="container">
                <h1 class="text-center">
                    <a href="{{ route('home') }}">KP陸戰隊</a>
                    ::
                    志工團</h1>
                <div class="d-grid gap-3">
                @foreach ($teams as $team)
                <div class="card">
                    <div class="card-header">
                    <a href="{{ url('team.show', ['id' => $team->id]) }}"><strong>{{ $team->name }}</strong></a>
                    </div>
                    <div class="card-body">
                        <p>{!! $team->note !!}</p>
                    </div>
                </div>
                @endforeach
                </div>
                {{ $teams->links() }}
            </main>
        </div>
    </body>
</html>
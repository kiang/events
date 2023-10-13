<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>KP陸戰隊::{{ $team->name }}</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
    
        <div id="app">
            <main class="container">
                <h1 class="text-center">
                    <a href="{{ route('home') }}">KP陸戰隊</a>
                    ::
                    {{ $team->name }}</h1>
                    <p>{!! $team->note !!}</p>
                <div class="d-grid gap-3">
                @foreach ($events as $event)
                <div class="card">
                    <div class="card-header">
                    <strong>{{ $event->name }}</strong>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>開始時間：{{ $event->time_gather }}</li>
                            @if (!empty($event->time_end))
                            <li>結束時間：{{ $event->time_end }}</li>
                            @endif
                            <li>集合地點：
                                @if (!empty($event->place->latitude))
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $event->place->latitude }},{{ $event->place->longitude }}&travelmode=driving" target="_blank">{{ $event->place->name }}</a>
                                @else
                                {{ $event->place->name }}
                                @endif
                            </li>
                            <li>舉辦團隊：{{ $event->team->name }}</li>
                        </ul>
                        <p>{!! $event->note !!}</p>
                        <div class="btn-group">
                        @foreach ($event->links as $link)
                        <a href="{{ $link->url }}" target="_blank" class="card-link">{{ $link->title }}</a>
                        @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
                {{ $events->links() }}
            </main>
        </div>
    </body>
</html>
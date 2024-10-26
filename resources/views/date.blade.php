<x-layout :id="$date->client_event->client->id" :name="$date->client_event->client->name">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('client', ['client' => $date->client_event->client])}}">ホーム</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('event', ['client_event' => $date->client_event])}}">{{ $date->client_event->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current='page'>{{ $date->date->format('Y/m/d')}}</li>
                </ol>
            </nav>
            <div class="row">
                @forelse($date->screenshots as $screenshot)
                    <div class="col mb-3">
                        <img src="{{ $screenshot->url }}" alt="{{ $screenshot->id }}" class="screenshot">
                        @auth
                            <div>{{ $screenshot->user->name }}</div>
                        @endauth
                    </div>
                @empty
                    提供できるスクショが存在しません
                @endforelse
            </div>
        </div>
    </x-slot>
</x-layout>

<x-layout :name="$date->client_event->client->name">
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
            <ul class="list-group d-flex flex-row justify-content-around" id="screenshots">
                @forelse($date->screenshots as $screenshot)
                    <li class="d-inline">
                        <img src="{{ $screenshot->url }}" alt="{{ $screenshot->id }}" class="screenshot">
                        @auth
                            <div class="text-center fs-6">
                                {{ $screenshot->user->name }}
                            </div>
                        @endauth
                    </li>
                @empty
                    提供できるスクショが存在しません
                @endforelse
            </ul>
        </div>
    </x-slot>
</x-layout>

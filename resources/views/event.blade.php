<x-layout :name="$event->client->name">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('client', ['client' => $event->client])}}">ホーム</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current='page'>イベント</li>
                </ol>
            </nav>
            <div class="list-group">
                @forelse($event->client_event_dates()->where('collected', true)->orderBy('date', 'desc')->get() as $date)
                    <a href="{{ route('date', ['client_event_date' => $date ]) }}" class="list-group-item list-group-item-action">
                        {{ $date->date->format('Y/m/d') }}:({{ $date->screenshots->count() }}枚)
                    </a>
                @empty
                    提供できるデータが存在しません
                @endforelse
            </div>
        </div>
    </x-slot>
</x-layout>

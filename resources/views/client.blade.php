<x-layout :name="$client->name">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current='page'>ホーム</li>
                </ol>
            </nav>
            <div class="list-group">
                @forelse($client->client_events()->orderBy('end_on', 'desc')->get() as $event)
                    <a href="{{ route('event', ['client_event' => $event ]) }}" class="list-group-item list-group-item-action">
                        {{ $event->event_name }}({{ $event->liver_name }}さん)
                    </a>
                @empty
                @endforelse
            </div>
        </div>
    </x-slot>
</x-layout>

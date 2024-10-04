<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
         @php
            $url = $getRecord() ? $getRecord()->url : "";
        @endphp
         <a href="{{ $url }}" target="_blank">{{ $url }}</a>
    </div>
</x-dynamic-component>

<div>
    @php
        $user_ids = $getRecord()->screenshots()->select('user_id')->get();
        $users = App\Models\User::whereNotIn('user_id', $user_ids->toArray())->get();
    @endphp
    {{ $getRecord()->screenshots()->count() }}
    ，未提出：
    @forelse($users as $user)
        {{ $user->name }}
        @if(!$loop->last)
            ，
        @endif
    @empty
        なし
    @endforelse
</div>

@php $total = count(auth()->user()->notifications);@endphp
<div class="card shadow" style="max-height: 28rem; height: auto">
    <div class="card-header justify-content-between">
        <div>Bildirishnomalar ({{$total}})</div>
{{--        @if($total)--}}
{{--        <form method="POST" action="#">--}}
{{--            @csrf--}}
{{--            <button onclick="return confirm('Barcha bildirishnomalar o\'chirilsinmi?')" class="btn btn-sm btn-outline-danger">Barchasini o'chirish</button>--}}
{{--        </form>--}}
{{--        @endif--}}
    </div>
    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
        <div class="divide-y">
            @forelse(auth()->user()->notifications()->latest()->limit(15)->get() as $notification)
                <div>
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <div class="badge bg-warning"></div>
                        </div>
                        <div class="col">
                            <div> <!-- class="text-truncate" -->
                                <p class="fw-bold mb-1">{{$notification->data['message']}}</p>
                            </div>
                            <div class="text-muted fst-italic">{{$notification->created_at?->diffForHumans()}}</div>
                        </div>
                        <form method="POST" action="{{route('notifications.delete', $notification->id)}}" class="col-auto align-self-center">
                            @csrf @method('DELETE')
                            <button class="btn btn-icon text-danger" onclick="return confirm('Bildirishnoma o\'chirilsinmi?')">
                                <x-svg.trash></x-svg.trash>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div>Yangi bildirishnomalar yo'q</div>
            @endforelse
        </div>
    </div>
</div>

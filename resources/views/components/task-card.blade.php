@props([
'item' => $task
])
{{--@dd($item->processes, $item)--}}
@php
    $percent = $item->approved ? round($item->approved * 100 / $item->processes, 2) : 0;
    $published = !!$item->published_at;
    $class = $published ? 'success' : 'secondary';
    $status = $item->published_at ? 'Aktiv' : 'Tasdiqlanmagan';
@endphp
<div class="card mb-3 pb-0">
    <div class="ribbon bg-red">{{ $percent }} % - {{$item->approved}} / {{$item->processes}}</div>
    <div class="card-header">
        <h3 class="card-title">{{$item->title}}</h3>
    </div>
    <div class="card-body">
        <p class="text-muted fw-bolder mb-1">
            <x-svg.calendar></x-svg.calendar> {{$item->expires_at?->format('d-M-Y')}} ({{$item->expires_at?->diffForHumans()}})
        </p>
        <p class="text-muted fw-bolder mb-1 ">
            <x-svg.tie></x-svg.tie> {{$item->user?->name}}
        </p>
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <span class="badge badge-blink bg-{{$class}} me-1"></span> <span class="badge bg-{{$class}}">{{$status}}</span>
            </div>
                <div class="text-end">
                @if(!$published)
                <a href="{{route('head.tasks.edit', $item->id)}}" class="btn btn-azure">
                    <x-svg.pen></x-svg.pen> Davom ettirish
                </a>
                @else
                <a href="{{route('head.process.task', $item->id)}}" class="btn btn-azure">
                    <x-svg.pen></x-svg.pen> Boshqarish
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="progress progress-sm card-progress">
        <div class="progress-bar" style="width: {{$percent}}%" role="progressbar" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100" aria-label="38% Complete">
            <span class="visually-hidden">{{$percent}}% Complete</span>
        </div>
    </div>
</div>

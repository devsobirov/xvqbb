@props([
    'item' => $task
])

<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{$item->task->title}}
            </h3>
            <p class="card-subtitle text-truncate text-wrap">
                {{$item->task->note}}
            </p>
        </div>
        <div class="card-actions">
            <button class="btn position-relative">
                {{$item->getStatusName()}} <span class="badge bg-{{$item->getStatusColor()}} badge-notification badge-blink"></span>
            </button>
        </div>
    </div>
    <div class="card-body p-0 px-3 pt-3">
        <p class="mb-2">
            <x-svg.calendar></x-svg.calendar> {{$item->task?->expires_at->format('d-M-Y')}}
            <span class="text-muted fst-italic ms-1">({{$item->task?->expires_at->diffForHumans()}})</span>
        </p>
        <p class="mb-2">
            <x-svg.briefcase></x-svg.briefcase> {{$item->department->name}}
        </p>
        <div class="text-end">
            <a href="{{route('branch.tasks.show', $item->id)}}" class="btn btn-primary">
                {{ $item->status == \App\Helpers\ProcessStatusHelper::PUBLISHED ? 'Tanishish' : 'Davom ettirish' }}
            </a>
        </div>
    </div>
</div>

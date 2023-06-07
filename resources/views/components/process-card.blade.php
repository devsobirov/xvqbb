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
            <span class="badge bg-azure">{{$item->task?->code}}</span>
        </div>
    </div>
    <div class="card-body px-3 pt-3">
        <p class="mb-2">
            <x-svg.calendar></x-svg.calendar> {{$item->task?->expires_at->format('d-M-Y')}}
            <span class="text-muted fst-italic ms-1">({{$item->task?->expires_at->diffForHumans()}})</span>
        </p>
        <p class="mb-2">
            <x-svg.briefcase></x-svg.briefcase> {{$item->department->name}}
        </p>
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <span class="badge bg-{{$item->getStatusColor()}} badge-blink"></span>
                <span class="badge bg-{{$item->getStatusColor()}}">{{$item->getStatusName()}}</span>
            </div>
            <a href="{{route('branch.tasks.show', $item->id)}}" class="btn btn-{{ $item->published() ? 'azure' : 'secondary'}}">
                <x-svg.pen></x-svg.pen> {{ $item->published() ? 'Tanishish' : 'Davom ettirish' }}
            </a>
        </div>
    </div>
</div>

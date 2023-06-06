@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{auth()->user()->branch->name}} filiali uchun topshiriqlar
                    </h2>
                    <div class="text-muted mt-1">{{$paginated->firstItem()}}-{{$paginated->lastItem()}} of {{$paginated->total()}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Topshiriq</th>
                            <th>Ma'sul</th>
                            <th>Muddati</th>
                            <th>Xolati</th>
                            <th>So'ngi amaliyot vaqti</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginated as $item)
                            <tr>
                                <td>{{$item->task->id}} - <span class="badge bg-azure">{{$item->task->code}}</span></td>
                                <td>
                                    <div class="flex-fill py-1">
                                        <div class="font-weight-medium">{{ $item->task->title }}</div>
                                        <div>{!! $item->task->notes !!}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-medium">{{ $item->department->name }}</div>
                                </td>
                                <td>
                                    <p class="text-nowrap ont-weight-medium mb-1">
                                        <x-svg.calendar></x-svg.calendar>{{$item->task->expires_at?->format('d-m-Y')}}
                                    </p>
                                    <p class="text-nowrap text-muted fst-italic fs-4">({{$item->task->expires_at?->diffForHumans()}})</p>
                                </td>
                                <td>
                                    <p><span class="badge bg-{{$item->getStatusColor()}} me-1"></span> {{$item->getStatusName()}}</p>
                                </td>
                                <td>
                                    @if($timestamp = $item->lastStatusChanged())
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-{{$item->getStatusColor()}} me-1"></span>
                                            <div>
                                                <p class="mb-1">{{$timestamp?->format('d/m-Y H:i')}}</p>
                                                <span class="fst-italic">({{$timestamp?->diffForHumans()}})</span>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == \App\Helpers\ProcessStatusHelper::PUBLISHED)
                                        <a class="btn btn-outline-secondary" href="{{route('branch.tasks.show', $item->id)}}">Tanishish</a>
                                    @else($item->department_id == auth()->user()->department_id && $item->published_at)
                                        <a class="btn btn-outline-azure" href="{{route('branch.tasks.show', $item->id)}}">Boshqarish</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if( $paginated->hasPages() )
                    <div class="card-footer pb-0">
                        {{ $paginated->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

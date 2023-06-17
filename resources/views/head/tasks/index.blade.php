@extends('layouts.app')

@php
    $filters = 0;
    if(!empty(request('search'))) { $filters++;}
    if(!empty(request('starts_from'))) { $filters++;}
    if(!empty(request('expires_from'))) { $filters++;}
    if(!empty(request('starts_to'))) { $filters++;}
    if(!empty(request('expires_to'))) { $filters++;}
    if(!empty(request('department_id'))) {$filters++;}
    if(is_numeric(request('status'))) {$filters++;}
@endphp
@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Topshiriqlar
                    </h2>
                    <div class="text-muted mt-1">{{$paginated->firstItem()}}-{{$paginated->lastItem()}} of {{$paginated->total()}}</div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                <form action="{{route('head.tasks.index')}}" class="d-md-flex d-sm-block">
                    <input type="search" class="form-control d-inline-block w-9 me-1 mb-1" placeholder="Kod, id, nomi ..." name="search" value="{{request('search')}}">
                    <button class="btn me-1 btn-icon btn-azure mb-1" title="Izlash"><x-svg.search></x-svg.search></button>
                    <button type="button" class="btn btn-azure me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal-report" title="filtrlar qo'llash">
                        <x-svg.filter></x-svg.filter> Filterlar qo'llash @if($filters) ({{$filters}}) @endif
                    </button>
                    <a href="{{route('head.tasks.create')}}" class="btn btn-primary mb-1">
                        <x-svg.plus></x-svg.plus> Yangi topshiriq
                    </a>
                </form>
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
                                <th>№ - Kod</th>
                                <th>Topshiriq</th>
                                <th>Bo'lim / Ma'sul</th>
                                <th>Muddat</th>
                                <th>Xolati</th>
                                <th>Progress</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($paginated as $item)
                            <tr>
                                <td>
                                    {{$item->id}} - <span class="badge bg-azure">{{$item->code}}</span>
                                </td>
                                <td>
                                    <div class="flex-fill py-1" style="max-width: 350px">
                                        <div class="font-weight-medium">{{ $item->title }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex-fill py-1" style="max-width: 350px">
                                        <div class="text-muted">
                                            <p class="mb-1"><x-svg.briefcase></x-svg.briefcase> {{$item->department?->name}}</p>
                                            <p class="mb-1"><x-svg.tie></x-svg.tie> {{$item->user?->name}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-1 text-muted text-nowrap">
                                        <x-svg.calendar></x-svg.calendar> {{$item->starts_at?->format('d.m.Y')}} - {{$item->expires_at?->format('d.m.Y')}}
                                    </p>
                                    <p class="mb-1 text-muted ps-3"><i>{{$item->expires_at?->diffForHumans()}}</i></p>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-{{$item->getStatusColor()}} badge-blink me-1"></span> {{$item->getStatusName()}}
                                </td>
                                <td>
                                    @if($item->total)
                                        <span class="badge">{{round($item->completed *100 / $item->total, 2)}} %</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if ($item->department_id == auth()->user()->department_id && $item->pending())
                                            <a class="btn btn-icon btn-yellow" href="{{route('head.tasks.edit', $item->id)}}"><x-svg.pen></x-svg.pen></a>
                                        @endif
                                        @if ($item->finished())
                                            <a class="btn btn-icon btn-azure" href="{{route('head.process.task', $item->id)}}"><x-svg.eye></x-svg.eye></a>
                                        @elseif(!$item->pending())
                                            <a class="btn btn-icon btn-success" href="{{route('head.process.task', $item->id)}}"><x-svg.pen></x-svg.pen></a>
                                        @endif
                                        @if (($item->department_id == auth()->user()->department_id || auth()->user()->isAdmin()) && !$item->finished())
                                            <form action="{{route('head.tasks.destroy', $item->id)}}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-icon btn-danger"
                                                        onclick="return confirm('Topshiriqni o\'chirishni xoxlaysizmi? Topshiriq va unga tegishli barcha jarayonlar va fayllar qaytarish imkonisiz o\'chiriladi')"
                                                ><x-svg.trash></x-svg.trash></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Topshiriqlar topilmadi</td>
                            </tr>
                        @endforelse
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

    @include('head.tasks._modal-filters')
@endsection

@extends('layouts.app')

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
                <div class="d-flex">
                    {{-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"> --}}
                    <a href="{{route('head.tasks.create')}}" class="btn btn-primary">
                        <x-svg.plus></x-svg.plus> Yangi topshiriq
                    </a>
                </div>
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
                                    <p class="mb-1 text-muted">
                                        <x-svg.calendar></x-svg.calendar> {{$item->starts_at?->format('d.m.Y')}} - {{$item->expires_at?->format('d.m.Y')}}
                                    </p>
                                    <p class="mb-1 text-muted ps-3"><i>{{$item->expires_at?->diffForHumans()}}</i></p>
                                </td>
                                <td>
                                    <span class="badge bg-{{$item->getStatusColor()}} badge-blink me-1"></span> {{$item->getStatusName()}}
                                </td>
                                <td>
                                    @if($item->total)
                                        {{round($item->completed *100 / $item->total, 2)}} %
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->department_id == auth()->user()->department_id && !$item->published_at)
                                        <a class="btn btn-yellow" href="{{route('head.tasks.edit', $item->id)}}">Davom ettirish</a>
                                    @endif
                                    @if ($item->department_id == auth()->user()->department_id && $item->published_at)
                                        <a class="btn btn-azure" href="{{route('head.process.task', $item->id)}}">Boshqarish</a>
                                    @endif
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
@endsection

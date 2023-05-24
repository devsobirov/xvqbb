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
                                <th>№</th>
                                <th>Nomi</th>
                                <th>Muddat</th>
                                <th>Ma'sul</th>
                                <th>Xolati</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($paginated as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <div class="flex-fill py-1">
                                        <div class="font-weight-medium">{{ $item->title }}</div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-1"><b>Start: </b>{{$item->starts_at?->format('d-m-Y')}}</p>
                                    <p class="mb-1"><b>Yakun: </b>{{$item->expires_at?->format('d-m-Y')}}</p>
                                </td>
                                <td>
                                    <p class="mb-1"><b>Bo'lim: </b>{{$item->department?->name}}</p>
                                    <p class="mb-1"><b>Xodim: </b>{{$item->user?->name}}</p>
                                </td>
                                <td>
                                    {{$item->published_at ? 'Aktiv' : 'Tasdiqlanmagan'}}
                                </td>
                                <td>
                                    @if ($item->department_id == auth()->user()->department_id && !$item->published_at)
                                        <a href="{{route('head.tasks.edit', $item->id)}}">Davom ettirish</a>
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

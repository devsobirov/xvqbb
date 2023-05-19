@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row g-2 align-items-center">
                <div class="col">
                <h2 class="page-title">
                    Ranbariyat bo'limlari
                </h2>
                <div class="text-muted mt-1">{{$paginated->firstItem()}}-{{$paginated->lastItem()}} of {{$paginated->total()}}</div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                    {{-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"> --}}
                    <a href="#" @click.prevent="alert('Keyingi versiyalardan mavjud')" class="btn btn-primary">
                        <x-svg.plus></x-svg.plus> Yangi bo'lim
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
                                <th>ID</th>
                                <th>Nomi</th>
                                <th>Xodimlar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($paginated as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <div class="flex-fill py-1">
                                        <div class="font-weight-medium">{{ $item->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    @forelse ($item->users as $user)
                                        <p>- {{$user->name}}</p>
                                    @empty
                                        <p>-</p>
                                    @endforelse
                                    <p></p>
                                </td>
                                <td></td>
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

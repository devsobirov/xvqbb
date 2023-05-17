@extends('layouts.app')

@php use App\Helpers\RoleHelper; @endphp
@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row g-2 align-items-center">
                <div class="col">
                <h2 class="page-title">
                    Xodimlar
                </h2>
                <div class="text-muted mt-1">{{$users->firstItem()}}-{{$users->lastItem()}} of {{$users->total()}}</div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                    {{-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"> --}}
                    <a href="{{route('users.create')}}" class="btn btn-primary">
                        <x-svg.plus></x-svg.plus> Yangi xodim
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
                                <th>{{ __('FIO') }}</th>
                                <th>{{ __('Lavozimi') }}</th>
                                <th>{{ __('Sana') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="flex-fill py-1">
                                        <div class="font-weight-medium">{{ $user->name }}</div>
                                        <div class="text-muted">{{ $user->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex-fill py-1">
                                        <div class="font-weight-medium">{{ RoleHelper::getRole($user->role) }}</div>
                                        <div class="text-muted">{{ $user->workplace()?->name ?? '-' }}</div>
                                    </div>

                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    @if (!$user->isAdmin())
                                        <a href="{{route('users.edit', $user->id)}}">Tahrirlash</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if( $users->hasPages() )
                <div class="card-footer pb-0">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

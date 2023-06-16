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
                <form action="{{route('users.index')}}" class="d-flex gap-2">
                    <input type="search" name="search" value="{{request('search')}}" class="form-control d-inline-block w-9" placeholder="FIO, email …">
                    <select class="form-select" name="role">
                        <option value="">Barcha lavozimlar</option>
                        @foreach (Role::ROLES as $id => $name)
                            <option value="{{$id}}" @if($id == request('role')) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary">Izlash</button>
                    <a href="{{route('users.create')}}" class="btn btn-primary">
                        <x-svg.plus></x-svg.plus> Yangi xodim
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
                                <th>{{ __('FIO') }}</th>
                                <th>Mutaxassis</th>
                                <th>Telegram ID</th>
                                <th>Yaratilgan</th>
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
                                        <div class="font-weight-medium">{{ \Role::getRole($user->role) }}</div>
                                        <div class="text-muted">{{ $user->workplace()?->name ?? '-' }}</div>
                                    </div>

                                </td>
                                <td>
                                    @if ($id = $user->telegram_chat_id)
                                        <span class="badge bg-blue-lt">{{$id}}</span>
                                    @else
                                        <span class="badge bg-secondary-lt">Obuna bo'lmagan</span>
                                    @endif
                                </td>
                                <td class="text-nowrap"><x-svg.calendar></x-svg.calendar> {{ $user->created_at->format('d-M-Y') }}</td>
                                <td>
                                    @if (!$user->isAdmin())
                                       <div class="flex-column gap-1">
                                           <a href="{{route('users.edit', $user->id)}}" class="btn btn-sm my-1 w-100 btn-yellow">
                                               <x-svg.pen></x-svg.pen> Tahrirlash
                                           </a>
                                           <form action="{{route('users.destroy', $user->id)}}" method="POST">
                                               @csrf @method('DELETE')
                                               <button class="btn btn-sm my-1 w-100 btn-danger" onclick="return confirm('Haqiqatdan ham foydalanuvchini o\'chirishni xoxlaysizmi?')">
                                                   <x-svg.trash></x-svg.trash> O'chirish
                                               </button>
                                           </form>
                                       </div>
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

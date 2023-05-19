@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{ config('app.name') }}
                </div>
                    <h2 class="page-title">
                        {{ $user->name }} ma'lumotlarini tahrirlash
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body" x-data="userEdit">
        <div class="container-xl">

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>
                        {{ $message }}
                    </div>
                  </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="card" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">{{ __('FIO') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}" value="{{ $user->name}}" required>
                        </div>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email') }}" value="{{ $user->email}}" required>
                        </div>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">Lavozimi</label>
                            <select class="form-select" name="role" x-model="role" @change="setSelectTab()">
                                <option value="" selected>Tanlang</option>
                                @foreach (Role::ROLES as $id => $name)
                                    <option @selected($user->role == $id) value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">Filial / Bo'lim</label>
                            <input type="email" class="form-control disabled" placeholder="Lavozimni tanlang" disabled x-cloak x-show="!tab">
                            <select class="form-select" name="branch_id" :required="tab === 'branch'" x-show="tab === 'branch'" x-cloak>
                                <option value="" selected disabled>Filailni tanlang</option>
                                @foreach ($branches as $branch)
                                    <option @selected($user->branch_id == $branch->id) value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                            <select class="form-select" name="department_id" :required="tab === 'department'" x-show="tab === 'department'" x-cloak>
                                <option value="" selected disabled>Bo'limni Tanlang</option>
                                @foreach ($departments as $department)
                                    <option @selected($user->department_id == $department->id) value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">Yangi Parol</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Faqat parol ozgartirish uchun">
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label required">Yangi parolni takrorlang</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Yangi parolni takrorlang" autocomplete="new-password">
                        </div>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>

            </form>

        </div>
    </div>

@endsection
@section('custom_scripts')
<script>
    function userEdit() {
        return {
            role: '',
            tab: '',
            init() {
                this.role = @json($user->role);
                this.setSelectTab();
            },
            setSelectTab() {
                if (parseInt(this.role) === 1 || parseInt(this.role) === 5) {
                    this.tab = 'department'
                } else if (parseInt(this.role) === 10) {
                    this.tab = 'branch'
                } else {
                    this.tab = ''
                }
            }
        }
    }
</script>
@endsection

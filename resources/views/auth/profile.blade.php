@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->

    <div class="page-body">
        <div class="container-xl"><div class="row py-4">
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

            <div class="col-md-6 col-sm-12">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h2 class="page-title">
                            Mening akkauntim
                        </h2>
                    </div>
                </div>
            <form action="{{ route('profile.update') }}" method="POST" class="card" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="card-body">


                    <div class="mb-3">
                        <label class="form-label required">Ism Familiya</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if (auth()->user()->isAdmin())
                    <div class="mb-3">
                        <label class="form-label required">Ish bo'limi</label>
                        <select class="form-select" name="department_id" required>
                            <option value="" selected disabled>Bo'limni tanlang</option>
                            @foreach ($departments as $department)
                                <option @selected(auth()->user()->department_id == $department->id) value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label required">Yangi parol</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Faqat parolni o'zgartirish kerak bo'lsa kiriting">
                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Yangi parolni takrorlang</label>
                        <input type="password" name="password_confirmation" placeholder="Faqat parolni o'zgartirish kerak bo'lsa kiriting" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                    </div>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>

            </form>
            </div>

            <div class="col-md-6 col-sm-12">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        Obunalarni boshqarish
                    </h2>
                </div>
            </div>

                <x-subscription-card>
                    @if(auth()->user()->telegram_chat_id)
                        <h3 class="card-title">Sizda botga obuna mavjud</h3>
                        <div class="mb-3">
                            <label class="form-label required">Telegram chat id</label>
                            <input type="text" class="form-control" readonly placeholder="xxxxxxxxx" value="{{ auth()->user()->telegram_chat_id ?? '-' }}">
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <a href="{{route('telegram.start')}}" class="btn btn-twitter me-2">
                                <x-svg.telegram></x-svg.telegram>
                                Qayta ulanish
                            </a>
                            <form action="{{route('telegram.unsubscribe')}}" method="POST">
                                @csrf
                                <button href="#" class="btn btn-pinterest w-100">
                                    <x-svg.bell-minus></x-svg.bell-minus> Bekor qilish
                                </button>
                            </form>
                        </div>
                    @else
                        <x-subscription-action></x-subscription-action>
                    @endif
                </x-subscription-card>
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

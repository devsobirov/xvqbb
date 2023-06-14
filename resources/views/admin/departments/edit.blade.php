@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        {{ $department->name }}
                    </div>
                    <h2 class="page-title">
                        Bo'lim ma'lumotlarini yangilash
                    </h2>
                </div>
                <a href="{{route('departments.index')}}" class="btn btn-primary">Barcha bo'limlar</a>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <form action="{{ route('departments.update', $department->id) }}" method="POST" class="card" autocomplete="off">
                @csrf @method('PATCH')

                <div class="card-body">

                    <div class="mb-3">
                        <div class="col-sm-12">
                            <label class="form-label required">Bo'lim nomi</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Axborot xavfsizligi va raqamli texnologiyalar bo'limi" value="{{$department->name}}" required>
                        </div>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="col-sm-12">
                            <label class="form-label required">
                                Prefix - faqat lotincha harf va "-" belgisi saqlagan 3 dan 20 gacha uzunlikdagi unikal matn, bo'limga doir fayllarni saqlash uchun papka nomi sifatida foydalaniladi</label>
                            <input type="text" readonly class="form-control @error('prefix') is-invalid @enderror" placeholder="Masalan, buxgalteriya-bolimi yoki dir-urinbosari" value="{{$department->prefix}}">
                            <input type="hidden" name="prefix" class="form-control @error('prefix') is-invalid @enderror" placeholder="Masalan, buxgalteriya-bolimi yoki dir-urinbosari" value="{{$department->prefix}}" required>
                        </div>
                        @error('prefix')
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

    </script>
@endsection

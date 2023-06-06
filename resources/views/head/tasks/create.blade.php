@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Yangi topshiriq yaratish
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-lg-8">
                <div class="card mb-4">
                  <form class="card-body" action="{{route('head.tasks.save')}}" method="POST">
                    @csrf
                    <h3 class="card-title">Asosiy ma'lumotlar</h3>
                    <div class="row mb-3">
                        <div class="col-md-8 col-sm-12">
                            <label for="title" class="form-label required">Topshiriq nomi</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Topshiriq №1" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="title" class="form-label required">Unikal kod</label>
                            <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="XXXXXXX" value="{{strtoupper(\Illuminate\Support\Str::random(6))}}" readonly required>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Ma'sul Bo'lim</label>
                            <input type="text" class="form-control @error('starts_at') is-invalid @enderror" value="{{$task->user?->department?->name ?? auth()->user()->department?->name}}" placeholder="">
                            <input type="hidden" name="department_id" value="{{$taks->department_id ?? auth()->user()->department_id}}">
                            @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Ma'sul Xodim</label>
                            <input type="text" class="form-control @error('starts_at') is-invalid @enderror" value="{{$task->user?->name ?? auth()->user()->name}}" placeholder="FIO" readonly>
                            <input type="hidden" name="user_id" value="{{$task->user_id ?? auth()->id()}}">
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-6">
                            <label for="" class="form-label required">Boshlanish sanasi</label>
                            <input type="date" class="form-control @error('starts_at') is-invalid @enderror" name="starts_at" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="" class="form-label required">Yakuniy sana</label>
                            <input type="date" class="form-control @error('expires_at') is-invalid @enderror" name="expires_at" min="{{date('Y-m-d')}}" required>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                          <label class="form-label">Qo'shimcha izoh</label>
                          <textarea class="form-control @error('note') is-invalid @enderror" name="note" data-bs-toggle="autosize" placeholder="Type something…">{{$task->note}}</textarea>
                          @error('note')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success">Saqlash</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Holati: yangi</h3>
                    <ul class="steps steps-vertical">
                      <li class="step-item active">
                        <div class="h4 m-0">Asosiy ma'lumotlar</div>
                        <div class="text-muted">Dastlab topshiriqning nomi, muddatlari va lozim bo'lsa izoh kiriting</div>
                      </li>
                      <li class="step-item">
                        <div class="h4 m-0">Fayllar yuklash</div>
                        <div class="text-muted">Topshiriq uchun zarur 1 yoki bir nechta fayllarni yuklang.</div>
                      </li>
                      <li class="step-item">
                        <div class="h4 m-0">Filiallarni belgilang</div>
                        <div class="text-muted">Topshiriqni qabul qiluvchi va bajaruvchi filiallrni belgilang.</div>
                      </li>
                      <li class="step-item">
                        <div class="h4 m-0">Tasdiqlash</div>
                        <div class="text-muted">Barcha ma'lumotlar kiritilganligiga amin bo'lgach, topshiriqni tasdiqlang.
                            Topshiriq faqat tasdiqlangandan so'nggina aktiv holatga o'tadi va kerakli xodimlarga jo'natiladi.
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

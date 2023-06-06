@extends('layouts.app')

@section('custom_styles')
<link rel="stylesheet" href="{{asset('vendor/dropzone/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('vendor/tabler-vendor.css')}}">
@endsection
@section('content')
    <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  {{$task->title}}
                </h2>
              </div>
            </div>
          </div>
    </div>
        <!-- Page body -->
        <div class="page-body" x-data="taskData">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-lg-8">
                @if (count($branchIds) && count($task->files))
                    <div class="card mb-4">
                        <form action="{{route('head.tasks.publish', ['task' => $task->id])}}" method="POST" class="d-flex align-items-start justify-content-between gap-1 p-3">
                            @csrf
                            <div>
                                Barcha ma'lumotlar kiritilganligiga amin bo'lgach, topshiriqni tasdiqlang.
                                Topshiriq faqat tasdiqlangandan so'nggina aktiv holatga o'tadi va kerakli xodimlarga jo'natiladi.
                                Tasdiqlangan topshiriqni qayta tahrirlash imkoni mavjud emas.
                            </div>
                            <button onclick="return confirm('Tasdiqlashni xoxlaysizmi?')" class="btn btn-primary">
                                Tasdiqlash
                            </button>
                        </form>
                    </div>
                @endif
                <div class="card mb-4">
                  <form class="card-body" action="{{route('head.tasks.save', ['task' => $task->id])}}" method="POST">
                    @csrf
                    <h3 class="card-title">Asosiy ma'lumotlar</h3>
                    <div class="row mb-3">
                        <div class="col-md-8 col-sm-12">
                            <label for="title" class="form-label required">Topshiriq nomi</label>
                            <input type="text" id="title" name="title" value="{{$task->title}}" class="form-control @error('title') is-invalid @enderror" placeholder="Topshiriq №1" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="title" class="form-label required">Unikal kod</label>
                            <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="XXXXXXX" value="{{$task->code}}" readonly required>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Ma'sul Bo'lim</label>
                            <input type="text" class="form-control @error('starts_at') is-invalid @enderror" value="{{$task->user?->department?->name}}" placeholder="">
                            <input type="hidden" name="department_id" value="{{$task->department_id}}">
                            @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Ma'sul Xodim</label>
                            <input type="text" class="form-control @error('starts_at') is-invalid @enderror" value="{{$task->user->name}}" placeholder="FIO" readonly>
                            <input type="hidden" name="user_id" value="{{$task->user_id}}">
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-6">
                            <label for="" class="form-label required">Boshlanish sanasi</label>
                            <input type="date" class="form-control @error('starts_at') is-invalid @enderror" name="starts_at" min="{{date('Y-m-d')}}" value="{{$task->starts_at?->format('Y-m-d')}}" required>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="" class="form-label required">Yakuniy sana</label>
                            <input type="date" class="form-control @error('expires_at') is-invalid @enderror" name="expires_at" value="{{$task->expires_at?->format('Y-m-d')}}" min="{{date('Y-m-d')}}" required>
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

                <div class="card mb-4">
                  <div class="card-body">
                    <h3 class="card-title">Fayllarni yuklash</h3>
                    <form class="dropzone dz-clickable" id="dropzone-multiple" action="./" autocomplete="off" novalidate="">
                        @csrf
                        <input type="hidden" name="filable_type" value="{{$task::class}}">
                        <input type="hidden" name="filable_id" value="{{$task->id}}">
                        <input type="hidden" name="dir" value="{{$task->getUploadDirName()}}">

                    <div class="dz-default dz-message"><button class="dz-button" type="button">Fayllarni tanlang yoki shu oynaga tashlang</button></div></form>
                  </div>

                  <div class="card-table table-responsive" x-show="files && files.length" x-cloak>
                    <table class="table table-vcenter">
                      <thead>
                        <tr>
                          <th>Fayl</th>
                          <th>Format</th>
                          <th>Hajm</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <template x-for="file in files">
                        <tr :key="file.id">
                            <td x-text="file.path"></td>
                            <td x-text="file.extension" class="text-muted"></td>
                            <td x-text="file.size + ' MB'" class="text-muted"></td>
                            <td class="text-muted">
                                <button class="btn btn-sm btn-danger" @click.prevent="removeFile(file.id)">O'chirish</button>
                            </td>
                        </tr>
                      </template>
                    </tbody></table>
                  </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Filiallar</h3>
                        <form class="row" method="POST" action="{{route('head.tasks.processes', ['task' => $task->id])}}">
                            @csrf
                            <div class="col-sm-12" x-cloak x-show="branchIds.length !== total">
                                <label class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        @click="toggleAllCheckboxes()"
                                        x-bind:checked="selectAll"
                                    >
                                    <span class="form-check-label"><b>Barcha filiallar</b></span>
                                </label>
                            </div>
                            @foreach ($branches as $branch)
                            <div class="col-md-6 col-sm-12" :key="{{$branch->id}}">
                                <label class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" @change="isAllSelected()" x-model="branchIds" name="branchIds[]" value="{{$branch->id}}">
                                    <span class="form-check-label">{{$branch->name}}</span>
                                </label>
                            </div>
                            @endforeach

                            <div class="text-end">
                                <button class="btn btn-success">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Holati: Tasdiqlanmagan</h3>
                    <ul class="steps steps-vertical">
                      <li class="step-item">
                        <div class="h4 m-0">Asosiy ma'lumotlar</div>
                        <div class="text-muted">Dastlab topshiriqning nomi, muddatlari va lozim bo'lsa izoh kiriting</div>
                      </li>
                      <li class="step-item" :class="(!files || !files.length) ? 'active' : ''">
                        <div class="h4 m-0">Fayllar yuklash</div>
                        <div class="text-muted">Topshiriq uchun zarur 1 yoki bir nechta fayllarni yuklang.</div>
                      </li>
                      <li class="step-item" :class="((!branchIds || !branchIds.length) && (files || files.length)) ? 'active' : ''">
                        <div class="h4 m-0">Filiallarni belgilang</div>
                        <div class="text-muted">Topshiriqni qabul qiluvchi va bajaruvchi filiallrni belgilang.</div>
                      </li>
                      <li class="step-item" :class="(branchIds && branchIds.length && files && files.length) ? 'active' : ''">
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

@section('custom_scripts')
    <script src="{{asset('vendor/dropzone/dropzone.min.js')}}"></script>

    <script>
        const initialBranches = @json($branchIds);
        const allBranchIds = @json($branches->pluck('id'));
        function taskData() {
            return {
                files: @json($task->files),
                branches: [],
                branchIds: initialBranches,
                selectAll: false,
                total: 0,
                init() {
                    this.dropzone();
                    document.addEventListener('upload', () => this.uploaded());
                    this.selectAll = (initialBranches.length === allBranchIds.length);
                    this.total = parseInt('{{$branches->count()}}');
                },
                dropzone() {
                    new Dropzone("#dropzone-multiple", {
                        init() {
                            console.log('init dropzone');
                            this.on("complete", () => {
                                document.dispatchEvent(new CustomEvent('upload'));
                            });
                            this.on("error", function (file, responseText) {
                                document.querySelector('.dz-error-message').textContent = responseText.message;
                            });
                        },
                        uploadMultiple: true,
                        parallelUploads: 1,
                        url: "{{ route('file.upload') }}",
                        method: 'post',
                        params: {
                            filable_type: '{{$task::class}}',
                            filable_id: '{{$task->id}}'
                        },
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    });
                },
                uploaded() {
                    this.$store.messages.success.push('File uploaded!');
                    this.getFiles();
                },
                async removeFile(id) {
                    console.log('deleting');
                    if (!confirm("Faylni o'chirishni xoxlaysizmi?")) return false;

                    try {
                        const res = await axios.delete(`{{route('head.tasks.deleteFile', ['task' => $task->id])}}/${id}`, {headers: defaultHeaders});
                        this.files = res.data.files ?? [];
                        this.$store.messages.success.push('Fayl muvaffaqiyatli o\'chirildi');
                    } catch (error) {
                        this.$store.messages.handleErrors(error.response);
                    }
                },
                async getFiles() {
                    try {
                        const res = await axios.get("{{route('head.tasks.getFiles', ['task' => $task->id])}}");
                        this.files = res.data.files ?? [];
                    } catch (error) {
                        this.$store.messages.handleErrors(error.response);
                    }
                },
                toggleAllCheckboxes() {
                    this.selectAll = !this.selectAll;

                    this.branchIds = this.selectAll ? allBranchIds : initialBranches;
                },
                isAllSelected() {
                    setTimeout(() => {
                        this.selectAll = (this.branchIds.length === this.total);
                    }, 300);
                }
            }
        }
    </script>
@endsection

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
                        <span class="badge bg-azure mx-1">{{$task->code}}</span> - {{$task->title}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body" x-data="taskData">
        <div class="container-xl">
            <div class="row row-cards">
                @if($process->status == \App\Helpers\ProcessStatusHelper::REJECTED)
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-{{$process->getStatusColor()}}"><x-svg.file-alert></x-svg.file-alert></div>
                            </div>
                            <div class="card-body">
                                @csrf
                                <h3 class="card-title">Topshiriq ijrosi qayta to'ldirish uchun bekor qilingan</h3>
                                <p class="mb-2">
                                    <x-svg.calendar></x-svg.calendar> {{$process->rejected_at->format('d-M-Y H:i')}}
                                </p>
                                <p class="mb-2">
                                    <strong>Izoh:</strong> {!! $process->reject_msg !!}
                                </p>
                                <p class="fw-medium">
                                    Kerakli o'zgartirish va to'ldirishlar kiritilgandan so'ng topshiriq ijrosini yakunlang va ko'rik uchun qayta topshiring
                                </p>
                                <form class="text-end" method="POST" action="{{route('branch.tasks.complete', $process->id)}}">
                                    <input type="hidden" name="rejected">
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Topshiriqni yakunlashni tasdiqlang')">
                                        <x-svg.checkbox></x-svg.checkbox> Topshiriqni qayta topshirish
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if($process->status == \App\Helpers\ProcessStatusHelper::PROCESSED)
                <div class="col-sm-12" x-cloak x-show="uploads && uploads.length">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-{{$process->getStatusColor()}}"><x-svg.checkbox></x-svg.checkbox></div>
                        </div>
                        <form action="{{route('branch.tasks.complete', $process->id)}}" method="POST" class="card-body">
                            @csrf
                            <h3 class="card-title">Topshiriq ijrosini yakunlash</h3>
                            <p>
                                Agar barcha kerakli fayllar yukalnganligi va talablar bajarilganiga amin bo'lsangiz topshiriq ijrosini yakunlang.
                                Yakunlangan topshiriq ma'sul xodimga moderatsiya uchun jo'natiladi va o'zgartirishlar kiritish mumkin bo'lmaydi.
                                Ijro tekshiruv natijaraliga ko'ra qabul qilinadi yoki qayta to'ldirish uchun bekor qilinadi.
                                <span class="fw-bolder">Xar br qayta urinish uchun imtiyoz blarriga jarima qo'llaniladi.</span>
                            </p>
                            <div class="text-end">
                                <button class="btn btn-green" onclick="return confirm('Topshiriqni yakunlshni tasdiqlang')">
                                    <x-svg.checkbox></x-svg.checkbox> Topshiriqni yakunlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @if($process->status == \App\Helpers\ProcessStatusHelper::COMPLETED)
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-{{$process->getStatusColor()}}"><x-svg.file-search></x-svg.file-search></div>
                        </div>
                        <div class="card-body">
                            @csrf
                            <h3 class="card-title">Topshiriq ijrosi ko'rik uchun topshrilgan</h3>
                            <p>

                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">Asosiy ma'lumotlar</h3>
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="" class="form-label">Ma'sul Bo'lim</label>
                                    <input type="text" class="form-control" value="{{$task->user?->department?->name}}" placeholder="">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="" class="form-label">Ma'sul Xodim</label>
                                    <input type="text" class="form-control" value="{{$task->user->name}}" placeholder="FIO" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6">
                                    <label for="" class="form-label required">Boshlanish sanasi</label>
                                    <input type="date" class="form-control" name="starts_at" min="{{date('Y-m-d')}}" value="{{$task->starts_at?->format('Y-m-d')}}" readonly required>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="" class="form-label required">Yakuniy sana</label>
                                    <input type="date" class="form-control" name="expires_at" value="{{$task->expires_at?->format('Y-m-d')}}" min="{{date('Y-m-d')}}" readonly required>
                                </div>
                            </div>
                            @if($task->note)
                                <div class="mb-3">
                                    <label class="form-label">Qo'shimcha izoh</label>
                                    <textarea class="form-control" name="note" data-bs-toggle="autosize" readonly>{{$task->note}}</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <x-process-progress :process="$process"></x-process-progress>

                    @if(in_array($process->status, [\App\Helpers\ProcessStatusHelper::UN_EXECUTED, \App\Helpers\ProcessStatusHelper::APPROVED]))
                        <div class="card my-3">
                            <div class="card-body">
                                <h3 class="card-title">Natija: </h3>
                                <p class="mb-1"><span class=" fw-medium"> Vaqt bo'yicha:</span> {{$process->accomplished ? 'Kechikmagan' : 'Qoniqarsiz'}}</p>
                                <p class="mb-1"><span class=" fw-medium"> O'rin:</span> {{$process->position ? $process->position . ' - chi bo\'lib' : '-'}}</p>
                                <p class="mb-1"><span class=" fw-medium"> Ball:</span> {{$process->score}}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row row-cards">

                @if($process->editable())
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Fayllarni yuklash</h3>
                                <form class="dropzone dz-clickable" id="dropzone-multiple" action="./" autocomplete="off" novalidate="">
                                    @csrf
                                    <input type="hidden" name="filable_type" value="{{$process::class}}">
                                    <input type="hidden" name="filable_id" value="{{$process->id}}">
                                    <input type="hidden" name="dir" value="{{$process->getUploadDirName()}}">
                                    <input type="hidden" name="file_name" value="{{$task->code}}">

                                    <div class="dz-default dz-message"><button class="dz-button" type="button">Fayllarni tanlang yoki shu oynaga tashlang</button></div></form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">Namuna uchun fayllar ({{count($files)}})</h3>
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
                                        <td x-text="getFileSize(file.size)" class="text-muted"></td>
                                        <td class="text-muted">
                                            <a :href="fileOpenUrl(file.id)" target="_blank" class="btn btn-sm btn-azure mx-1">Ko'rish</a>
                                            <a :href="fileLoadUrl(file.id)" target="_blank" class="btn btn-sm btn-azure mx-1">Yuklab olish</a>
                                        </td>
                                    </tr>
                                </template>
                                </tbody></table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title" x-text="`Ijro uchun yuklangan fayllar (${uploads ? uploads.length : 0})`"></h3>
                        </div>
                        <div class="card-table table-responsive">
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
                                <template x-for="file in uploads" x-show="uploads && uploads.length" x-cloak>
                                    <tr :key="file.id">
                                        <td x-text="file.path"></td>
                                        <td x-text="file.extension" class="text-muted"></td>
                                        <td x-text="getFileSize(file.size)" class="text-muted"></td>
                                        <td class="text-muted">
                                            <a :href="fileOpenUrl(file.id)" target="_blank" class="btn btn-sm btn-azure mx-1">Ko'rish</a>
                                            @if($process->editable())
                                                <button class="btn btn-sm btn-danger" @click.prevent="removeFile(file.id)">O'chirish</button>
                                            @endif
                                        </td>
                                    </tr>
                                </template>
                                <tr x-cloak x-show="!uploads || !uploads.length">
                                    <td colspan="4" class="text-center">Yuklangan fayllar mavjud emas</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('custom_scripts')
            <script src="{{asset('vendor/dropzone/dropzone.min.js')}}"></script>

            <script>
                function taskData() {
                    return {
                        files: @json($files),
                        uploads: @json($process->files),
                        init() {
                            this.dropzone();
                            document.addEventListener('upload', () => this.uploaded());
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
                                    filable_type: '{{$process::class}}',
                                    filable_id: '{{$process->id}}'
                                },
                                'headers': {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            });
                        },
                        uploaded() {
                            this.$store.messages.success.push('Fayl yuklandi!');
                            this.getFiles();
                        },
                        async removeFile(id) {
                            console.log('deleting');
                            if (!confirm("Faylni o'chirishni xoxlaysizmi?")) return false;

                            try {
                                const res = await axios.delete(`{{route('branch.tasks.deleteFile', ['process' => $process->id])}}/${id}`, {headers: defaultHeaders});
                                this.uploads = res.data.files ?? [];
                                this.$store.messages.success.push('Fayl muvaffaqiyatli o\'chirildi');
                            } catch (error) {
                                this.$store.messages.handleErrors(error.response);
                            }
                        },
                        async getFiles() {
                            try {
                                const res = await axios.get("{{route('branch.tasks.getFiles', ['process' => $process->id])}}");
                                this.uploads = res.data.files ?? [];
                            } catch (error) {
                                this.$store.messages.handleErrors(error.response);
                            }
                        },
                    }
                }
            </script>
@endsection

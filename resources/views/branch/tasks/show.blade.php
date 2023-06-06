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
                        <span class="badge bg-azure">{{$task->code}} - </span>{{$task->title}}
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
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Joriy holat: <span class="ms-2 me-1 badge badge-blink bg-{{$process->getStatusColor()}}"></span> {{$process->getStatusName()}}</h3>
                            <ul class="steps steps-vertical">
                                @foreach(\App\Helpers\ProcessStatusHelper::STATUSES as $id => $status)
                                    @if(!in_array($id, [\App\Helpers\ProcessStatusHelper::PENDING, \App\Helpers\ProcessStatusHelper::REJECTED]))
                                        <li class="step-item {{$process->status == $id ? 'active' : ''}}">
                                            <div class="h4 m-0">{{$status}}</div>
                                            <div class="text-muted">{{$process->updatedAt($id)?->format('d-M-Y H:i')}}</div>
                                        </li>
                                    @endif
                                    @if($process->status == \App\Helpers\ProcessStatusHelper::REJECTED)
                                        <li class="step-item {{$process->status == $id ? 'active' : ''}}">
                                            <div class="h4 m-0">{{$status}}</div>
                                            <div class="text-muted">{{$process->updatedAt($id)?->format('d-M-Y H:i')}}</div>
                                            <div class="text-danger">{{$process->reject_msg}}</div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cards">

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
                                        <td x-text="file.size + ' MB'" class="text-muted"></td>
                                        <td class="text-muted">
                                            <button class="btn btn-sm btn-azure">Yuklab olish</button>
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
                            <h3 class="card-title">Fayllarni yuklash</h3>
                            <form class="dropzone dz-clickable" id="dropzone-multiple" action="./" autocomplete="off" novalidate="">
                                @csrf
                                <input type="hidden" name="filable_type" value="{{$process::class}}">
                                <input type="hidden" name="filable_id" value="{{$process->id}}">
                                <input type="hidden" name="dir" value="{{$process->getUploadDirName()}}">

                                <div class="dz-default dz-message"><button class="dz-button" type="button">Fayllarni tanlang yoki shu oynaga tashlang</button></div></form>
                        </div>

                        <div class="card-table table-responsive" x-show="uploads && uploads.length" x-cloak>
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
                                <template x-for="file in uploads">
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

@extends('layouts.app')

@section('custom_styles')
    <link rel="stylesheet" href="{{asset('vendor/dropzone/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/tabler-vendor.css')}}">
@endsection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="page-pretitle mb-1"><span class="badge bg-azure mx-1">{{$task->code}}</span> - {{$task->title}}</div>
                    <h2 class="page-title">
                        <span class="badge bg-azure mx-1">{{$process->code}}</span> - {{$process->branch?->name}}
                    </h2>
                </div>

                <a href="{{route('head.process.task', $task->id)}}" class="btn btn-azure">
                    <x-svg.tasks></x-svg.tasks> Filiallarga qaytish
                </a>
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

                <div class="col-lg-4">
                    <x-process-progress :process="$process"></x-process-progress>
                </div>

            </div>

            @if($process->status == \App\Helpers\ProcessStatusHelper::COMPLETED)
                <div class="col-sm-12 mt-3">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-azure"><x-svg.file-search></x-svg.file-search></div>
                        </div>
                        <form action="{{route('branch.tasks.complete', $process->id)}}" method="POST" class="card-body">
                            @csrf
                            <h3 class="card-title">Topshiriq ijrosini baholash</h3>
                            <p>
                                Qabul qilingan ijro qayta o'zgartirish kiritish va bekor qilish uchun mavjud bo'lmaydi,
                                qabul qilingan statusi biriktiladi va ijrochiga imtiyoz ballari o'tkaziladi.
                            </p>
                            <div class="text-end">
                                <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#modal-approve">
                                    <x-svg.checkbox></x-svg.checkbox> Qabul qilish
                                </button>

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-reject">
                                    <x-svg.file-alert></x-svg.file-alert>  Bekor qilish
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        @include('head.processes._modal-approve')
        @include('head.processes._modal-reject')

        @endsection

        @section('custom_scripts')
            <script src="{{asset('vendor/dropzone/dropzone.min.js')}}"></script>

            <script>
                function taskData() {
                    return {
                        files: @json($files),
                        uploads: @json($process->files),
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
                    }
                }
            </script>
@endsection

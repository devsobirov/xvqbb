@extends('layouts.app')

@php
$filesCount = $task->files->count();
@endphp
@section('content')
    <div class="container-xl" x-data="taskData">
        <div class="page-header">
            <div class="page-pretitle">
                {{$task->department->name}}, {{$task->user?->name}}
            </div>
            <h2 class="page-title">
                <span class="badge bg-azure mx-1">{{$task->code}}</span> - {{$task->title}}
            </h2>
            <div class="d-flex align-items-center mt-2">
                <p class="mb-1 text-muted text-nowrap">
                    <x-svg.calendar></x-svg.calendar> {{$task->starts_at?->format('d.m.Y')}} - {{$task->expires_at?->format('d.m.Y')}}
                </p>
                <p class="mb-1 ms-2">
                    , <span class="badge bg-{{$task->getStatusColor()}} badge-blink me-1"></span> {{$task->getStatusName()}}
                </p>
            </div>
        </div>
        <div class="page-body">
            <div class="row mb-4">
                <div class="col-md-6 col-sm-12 mb-1">
                    <x-task-progress :processes="$processes"></x-task-progress>
                </div>
                <div class="col-md-6 col-sm-12 mb-1">
                    <div class="card">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jarayonlar</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th class="w-1">Code</th>
                                <th>Filial</th>
                                <th>Fayllar</th>
                                <th>Status</th>
                                <th>So'ngi amaliyot vaqti</th>
                                <th>Natija</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($processes as $process)
                                <tr>
                                    <td>
                                        <span class="text-muted">{{$process->position ?? '-'}}
                                    </td>
                                    <td>
                                        <span class="text-muted">№{{$process->id}}</span> - <span class="badge bg-azure">{{$process->code}}</span>
                                    </td>
                                    <td><a href="#" class="text-reset" tabindex="-1">{{$process->branch?->name}}</a></td>
                                    <td class="text-nowrap">
                                        <a href="#" class="text-muted">
                                            <x-svg.check></x-svg.check> {{$process->files_count}}/{{$filesCount}}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{$process->getStatusColor()}} me-1"></span> {{$process->getStatusName()}}
                                    </td>
                                    <td>
                                        @if($timestamp = $process->lastStatusChanged())
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-{{$process->getStatusColor()}} me-1"></span>
                                            <div>
                                                <p class="mb-1">{{$timestamp?->format('d/m-Y H:i')}}</p>
                                                <span class="fst-italic">({{$timestamp?->diffForHumans()}})</span>
                                            </div>
                                        </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($process->score)
                                        <p class="mb-1">{{$process->score}} ball</p>
                                        <span class="badge bg-{{$process->accomplished ? 'green' : 'danger'}}">
                                            {{$process->accomplished ? "Kechikmagan" : 'Qoniqarsiz'}}
                                        </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{route('head.process.process', $process->id)}}" class="btn btn-azure">
                                            <x-svg.file-search></x-svg.file-search> Boshqarish
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script>
        function taskData() {
            return {
                uploads: @json($task->files)
            }
        }
    </script>
@endsection

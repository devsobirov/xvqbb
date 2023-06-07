@extends('layouts.app')

@php
$filesCount = $task->files->count();
@endphp
@section('content')
    <div class="container-xl">
        <div class="page-header"></div>
        <div class="page-body">
            <div class="row mb-4">
                <div class="col-md-6 col-sm-12">
                    <x-task-progress :processes="$processes"></x-task-progress>
                </div>
                <div class="col-md-6 col-sm-12">

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
                                <th>Filial</th>
                                <th>Fayllar</th>
                                <th>Status</th>
                                <th>So'ngi amaliyot vaqti</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($processes as $process)
                                <tr>
                                    <td><span class="text-muted">{{$process->id}}</span></td>
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

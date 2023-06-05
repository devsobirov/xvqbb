@extends('layouts.app')

@php
$filesCount = $task->files->count();
$processesCount = $processes->count();
@endphp
@section('content')
    <div class="container-xl">
        <div class="page-header"></div>
        <div class="page-body">
            <div class="row mb-4">
                <div class="col-md-6 col-sm-12">
                    @php
                    $published = $processes->where('status', \App\Helpers\ProcessStatusHelper::PUBLISHED)->count();
                    $processed = $processes->where('status', \App\Helpers\ProcessStatusHelper::PROCESSED)->count();
                    $completed = $processes->where('status', \App\Helpers\ProcessStatusHelper::COMPLETED)->count();
                    $rejected = $processes->where('status', \App\Helpers\ProcessStatusHelper::REJECTED)->count();
                    $approved = $processes->where('status', \App\Helpers\ProcessStatusHelper::APPROVED)->count();
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-3">Jami <strong>{{count($processes)}} </strong> filialga jo'natilgan</p>
                            <div class="progress progress-separated mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{round($approved/$processesCount*100)}}%" aria-label="Qabul qilingan"></div>
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{round($completed/$processesCount*100)}}%" aria-label="Bajarilgan"></div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{round($processed/$processesCount*100)}}%" aria-label="Jarayonda"></div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{round($rejected/$processesCount*100)}}%" aria-label="Bekor qilingan"></div>
                            </div>
                            <div class="row">
                                <div class="col-auto d-flex align-items-center pe-2">
                                    <span class="legend me-2 bg-success"></span>
                                    <span>Qabul qilingan</span>
                                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$approved}}</span>
                                </div>
                                <div class="col-auto d-flex align-items-center px-2">
                                    <span class="legend me-2 bg-primary"></span>
                                    <span>Bajarilgan</span>
                                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$completed}}</span>
                                </div>
                                <div class="col-auto d-flex align-items-center px-2">
                                    <span class="legend me-2 bg-warning"></span>
                                    <span>Jarayonda</span>
                                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$processed}}</span>
                                </div>
                                <div class="col-auto d-flex align-items-center px-2">
                                    <span class="legend me-2 bg-danger"></span>
                                    <span>Bekor qilingan</span>
                                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$rejected}}</span>
                                </div>
                                <div class="col-auto d-flex align-items-center ps-2">
                                    <span class="legend me-2"></span>
                                    <span>Tanishilmagan</span>
                                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$published}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <span class="dropdown">
                                          <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                          <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">
                                              Action
                                            </a>
                                            <a class="dropdown-item" href="#">
                                              Another action
                                            </a>
                                          </div>
                                        </span>
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

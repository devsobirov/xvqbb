@extends('layouts.app')

@section('custom_styles')
    <style>
        .w-75 {width: 75% !important;}
    </style>
@endsection

@php
    $filters = 0;
    $departmentLabel = "barcha bo'limlar";
    if(!empty(request('from'))) { $filters++;}
    if(!empty(request('to'))) { $filters++;}
    if(!empty(request('department_id'))) {
        $filters++;
        $currentDep = $departments->where('id', request('department_id'))->first();
        $departmentLabel = $currentDep ? ($currentDep->name . " bo'limi") : $departmentLabel;
    }


@endphp
@section('content')
    <div class="page-body">
        <div class="container-xl">

            <div class="row g-2 align-items-center mb-4">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Statistika
                    </div>
                    <h2 class="page-title">
                        {{ \Carbon\Carbon::parse($from)->format('d.M.Y')}} dan - {{ \Carbon\Carbon::parse($to)->format('d.M.Y')}} gacha bo'lgan muddatda {{$departmentLabel}} uchun statistika
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <x-svg.filter></x-svg.filter>
                            Filterlar qo'llash @if($filters) ({{$filters}}) @endif
                        </a>
                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mb-4">

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Jami topshiriqlar</div>
                            </div>
                            <div class="h1 mb-3">{{$totalTasks}} ta</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Jami jarayonlar</div>
                            </div>
                            <div class="h1 mb-3">{{$totalProcesses}} ta</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Bajarilgan</div>
                            </div>
                            <div class="h1 mb-3">{{$totalCompletedRate}}%</div>
                            <div class="d-flex mb-2">
                                <div>Bajarilish unumdorligi</div>
                                <div class="ms-auto">
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                  {{ $totalCompleted }}/{{$totalProcesses}}
                                </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{$totalCompletedRate}}%" role="progressbar" aria-valuenow="{{$totalCompletedRate}}" aria-valuemin="0" aria-valuemax="100" aria-label="{{$totalCompletedRate}}% Complete">
                                    <span class="visually-hidden">{{$totalCompletedRate}} Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Muddatida</div>
                            </div>
                            <div class="h1 mb-3">{{$totalValidityRate}}%</div>
                            <div class="d-flex mb-2">
                                <div>Kechikmasdan bajarilgan</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{$totalValid}} / {{$totalProcesses}}
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{$totalValidityRate}}%" role="progressbar" aria-valuenow="{{$totalValidityRate}}" aria-valuemin="0" aria-valuemax="100" aria-label="{{$totalValidityRate}}% Complete">
                                    <span class="visually-hidden">{{$totalValidityRate}}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mb-4">

                <div class="col-md-4 col-sm-12">
                    <div class="card" style="height: auto; max-height: 30rem">
                        <div class="card-header">
                            <h3 class="card-title">Jamg'arilgan ballar bo'yicha</h3>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow p-0">
                            <table class="table card-table table-vcenter">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Filial</th>
                                    <th>Jami topsh.</th>
                                    <th>Ball</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($branches as $branch)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td class="w-50">{{$branch->name}}</td>
                                        <td>{{$branch->total}}</td>
                                        <td>
                                            <span class="badge">{{$branch->score}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card" style="height: auto; max-height: 30rem">
                        <div class="card-header">
                            <h3 class="card-title">Muddatida bajarish ko'rsatkichi</h3>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow p-0">
                            <table class="table card-table table-vcenter">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Filial</th>
                                    <th colspan="2">Kechikmasdan bajargan %</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($branches->sortByDesc('validity') as $branch)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$branch->name}}</td>
                                        <td class="w-50">
                                            <div class="flex-column align-items-center">
                                                <div class="mb-1"><span class="badge">{{$branch->validity}}%</span> ({{$branch->valid}} ta/{{$branch->total}} dan)</div>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-primary" style="width: {{$branch->validity}}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="card" style="height: auto; max-height: 30rem">
                        <div class="card-header">
                            <h3 class="card-title">Bo'limlar kesimida</h3>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow p-0">
                            <table class="table card-table table-vcenter">
                                <thead>
                                <tr>
                                    <th class="w-75">Bo'lim</th>
                                    <th>Topshiriqlar</th>
                                    <th>Jarayonlar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($departments->sortByDesc('tasks') as $department)
                                    <tr>
                                        <td class="w-75">{{$department->name}}</td>
                                        <td>{{$department->tasks}}</td>
                                        <td>{{$department->processes}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </div>

    @include('head.stats._modal-filters')
@endsection
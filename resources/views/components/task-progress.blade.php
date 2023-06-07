@props(['processes])
@php
        $processesCount = $processes->count();
        $published = $processes->where('status', \App\Helpers\ProcessStatusHelper::PUBLISHED)->count();
        $processed = $processes->where('status', \App\Helpers\ProcessStatusHelper::PROCESSED)->count();
        $completed = $processes->where('status', \App\Helpers\ProcessStatusHelper::COMPLETED)->count();
        $rejected = $processes->where('status', \App\Helpers\ProcessStatusHelper::REJECTED)->count();
        $approved = $processes->where('status', \App\Helpers\ProcessStatusHelper::APPROVED)->count();
@endphp
<div class="card">
    <div class="card-body">
        <p class="mb-3">Jami <strong>{{$processesCount}} </strong> filialga jo'natilgan</p>
        <div class="progress progress-separated mb-3">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{round($approved/$processesCount*100)}}%" aria-label="Qabul qilingan"></div>
            <div class="progress-bar bg-primary" role="progressbar" style="width: {{round($completed/$processesCount*100)}}%" aria-label="Bajarilgan"></div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{round($processed/$processesCount*100)}}%" aria-label="Jarayonda"></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: {{round($rejected/$processesCount*100)}}%" aria-label="Bekor qilingan"></div>
        </div>
        <div class="row">
            <div class="col-auto d-flex align-items-center ps-2">
                <span class="legend me-2"></span>
                <span>Tanishilmagan</span>
                <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$published}}</span>
            </div>
            <div class="col-auto d-flex align-items-center px-2">
                <span class="legend me-2 bg-warning"></span>
                <span>Jarayonda</span>
                <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$processed}}</span>
            </div>
            <div class="col-auto d-flex align-items-center px-2">
                <span class="legend me-2 bg-primary"></span>
                <span>Bajarilgan</span>
                <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$completed}}</span>
            </div>

            <div class="col-auto d-flex align-items-center px-2">
                <span class="legend me-2 bg-danger"></span>
                <span>Bekor qilingan</span>
                <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$rejected}}</span>
            </div>
            <div class="col-auto d-flex align-items-center pe-2">
                <span class="legend me-2 bg-success"></span>
                <span>Qabul qilingan</span>
                <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$approved}}</span>
            </div>
        </div>
    </div>
</div>

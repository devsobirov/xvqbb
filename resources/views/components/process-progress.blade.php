@props(['process'])
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Joriy holat: <span class="ms-2 me-1 badge badge-blink bg-{{$process->getStatusColor()}}"></span> <span class="badge bg-{{$process->getStatusColor()}}">{{$process->getStatusName()}}</span></h3>
        <ul class="steps steps-vertical">
            @foreach(\App\Helpers\ProcessStatusHelper::getVisibleStatuses() as $id => $status)

                @if($process->status == \App\Helpers\ProcessStatusHelper::REJECTED && $process->status == $id)
                    <li class="step-item {{$process->status == $id ? 'active' : ''}}">
                        <div class="h4 m-0">{{$status}}</div>
                        <div class="text-muted">{{$process->updatedAt($id)?->format('d-M-Y H:i')}}</div>
                        <div class="text-danger">{{$process->reject_msg}}</div>
                    </li>
                @elseif($id != \App\Helpers\ProcessStatusHelper::REJECTED)
                    <li class="step-item {{$process->status == $id ? 'active' : ''}}">
                        <div class="h4 m-0">{{$status}}</div>
                        <div class="text-muted">{{$process->updatedAt($id)?->format('d-M-Y H:i')}}</div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

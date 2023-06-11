<?php

namespace App\Providers;

use App\Events\ProcessApproved;
use App\Events\ProcessCompleted;
use App\Events\ProcessRejected;
use App\Events\ProcessTerminated;
use App\Events\TaskClosed;
use App\Events\TaskExpired;
use App\Events\TaskPublished;
use App\Listeners\CheckIsTaskFinished;
use App\Listeners\HandleApprovedProcess;
use App\Listeners\HandleClosedTask;
use App\Listeners\HandleExpiredTask;
use App\Listeners\HandleRejectedProcess;
use App\Listeners\HandleTerminatedProcess;
use App\Listeners\NotifyApprovedProcess;
use App\Listeners\NotifyAssignedTask;
use App\Listeners\NotifyClosedTask;
use App\Listeners\NotifyCompletedProcess;
use App\Listeners\NotifyExpiredTask;
use App\Listeners\NotifyRejectedProcess;
use App\Listeners\NotifyTerminatedProcess;
use App\Listeners\PublishProcesses;
use App\Models\Task;
use App\Observers\TaskObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TaskPublished::class => [
            PublishProcesses::class,
            NotifyAssignedTask::class
        ],
        TaskExpired::class => [
            HandleExpiredTask::class,
            NotifyExpiredTask::class
        ],
        TaskClosed::class => [
            HandleClosedTask::class,
            NotifyClosedTask::class
        ],
        ProcessCompleted::class => [
            NotifyCompletedProcess::class,
        ],
        ProcessApproved::class => [
            HandleApprovedProcess::class,
            NotifyApprovedProcess::class,
            CheckIsTaskFinished::class
        ],
        ProcessRejected::class => [
            HandleRejectedProcess::class,
            NotifyRejectedProcess::class
        ],
        ProcessTerminated::class => [
            HandleTerminatedProcess::class,
            NotifyTerminatedProcess::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

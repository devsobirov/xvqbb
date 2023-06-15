<?php

namespace Database\Seeders;

use App\Events\ProcessApproved;
use App\Events\TaskClosed;
use App\Events\TaskPublished;
use App\Helpers\ProcessStatusHelper;
use App\Models\Branch;
use App\Models\Department;
use App\Models\File;
use App\Models\Process;
use App\Models\Task;
use App\Services\AssignBranchProcesses;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Generating 500 tasks in last 3 month period with random processes
 *
 * Class TaskTableSeeder
 * @package Database\Seeders
 */
class TaskTableSeeder extends Seeder
{
    public $faker;

    public static array $months = [
        3 => '2023-03-',
        4 => '2023-04-',
        5 => '2023-05-',
        6 => '2023-06-'
    ];

    public ?int $branchesCount = null;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run(): void
    {
        for ($i = 1; $i < 500; $i++) {
            $task = $this->createNewTask();
            $this->attachFile($task, true);
            $this->attachProcesses($task);
            TaskPublished::dispatch($task);
            $this->handleProcesses($task);
            $this->finishTask($task);
        }
    }

    protected function createNewTask(): Task
    {
        $department = DB::table('departments')->select('id')->inRandomOrder()->limit(1)->get()->first();
        $owner = DB::table('users')->where('department_id', $department->id)->limit(1)->get()->first();

        $starts_day = rand(1, 25);
        $expire_day = rand($starts_day + 2, 30);
        $month = self::$months[rand(3,6)];

        return Task::create([
            'title' => $this->faker->words(rand(2,5), true),
            'code' => Str::random(8),
            'department_id' => $department->id,
            'user_id' => $owner?->id,
            'created_at' => $month.$starts_day,
            'starts_at' => $month.$starts_day,
            'published_at' => $month.$starts_day,
            'expires_at' => $month. $expire_day,
        ]);
    }
    protected function attachFile(object $filable, $task = false)
    {
        File::create([
            'filable_type' => $filable::class,
            'filable_id' => $filable->id,
            'extension' => 'txt',
            'size' => rand(100, 2000),
            'user_id' => rand(1, 10),
            'path' => 'files'. DIRECTORY_SEPARATOR . ($task ? 'task' : 'result') . '.txt'
        ]);
    }
    protected function attachProcesses(Task $task)
    {
        $branches = DB::table('branches')->select('id')->limit(rand(3, $this->getMaxBranchesAmount()))->get();
        $branchIds = $branches->pluck('id')->toArray();
        (new AssignBranchProcesses())->handle($task, $branchIds);
    }
    protected function handleProcesses(Task $task)
    {
        $periodArray = explode('-', str_replace(' 00:00:00', '', $task->starts_at));
        $start_day = $periodArray[2];
        $month = $periodArray[0].'-'.$periodArray[1].'-';

        foreach ($task->processes as $process) {
            $this->handleProcess($process, $start_day, $month);
        }
    }
    protected function finishTask(Task $task)
    {

        $finished_at  = DB::table('processes')->where('task_id', $task->id)->max('completed_at') ?? $task->expires_at;
        $task->finished_at = $finished_at;
        $task->save();

        foreach ($task->processes()->where('status', ProcessStatusHelper::APPROVED)->orderBy('completed_at')->get() as $process) {
            ProcessApproved::dispatch($process);
        }

        TaskClosed::dispatch($task);
    }

    protected function handleProcess(Process $process, int $start_day, string $month)
    {
        $process->status = $this->getRandomProcessStatus();
        $process->processed_at = $month.$start_day;

        if ($process->status == ProcessStatusHelper::APPROVED) {
            $this->attachFile($process);
            $process->completed_at = $month . rand($start_day, 29);
            $process->approved_at = $month . 29;
            $process->attempts = rand(1,2);
        }

        $process->save();
    }

    protected function getMaxBranchesAmount(): int
    {
        if (!$this->branchesCount) {
            $this->branchesCount = DB::table('branches')->count();
        }

        return $this->branchesCount;
    }
    protected function getRandomProcessStatus(): int
    {
        $completed = rand(1,9) > 2;

        return $completed ? ProcessStatusHelper::APPROVED : ProcessStatusHelper::PROCESSED;
    }
}

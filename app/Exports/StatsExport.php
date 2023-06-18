<?php

namespace App\Exports;

use JetBrains\PhpStorm\Pure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StatsExport implements WithMultipleSheets
{
    public function __construct(public array $data){}

    #[Pure] public function sheets(): array
    {
        return [
            '1' => new EfficiencyExport($this->data),
            '2' => new CompletencyExport($this->data),
            '3' => new DepartmentExport($this->data),
        ];
    }
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class EfficiencyExport implements FromView, WithTitle, WithColumnWidths
{
    public function __construct(public array $data)
    {
    }

    public function view(): View
    {
        return view('exports.efficiency-report', $this->data);
    }

    public function title(): string
    {
        return "Ballar bo'yicha";
    }

    public function columnWidths(): array
    {
        return [
            'B' => 30,
            'C' => 20,
            'D' => 20,
        ];
    }
}

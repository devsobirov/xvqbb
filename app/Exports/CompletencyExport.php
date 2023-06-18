<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class CompletencyExport implements FromView, WithTitle, WithColumnWidths
{
    public function __construct(public array $data)
    {
    }

    public function view(): View
    {
        return view('exports.completency-report', $this->data);
    }

    public function title(): string
    {
        return "Muddat bo'yicha";
    }

    public function columnWidths(): array
    {
        return [
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
        ];
    }
}

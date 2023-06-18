<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class DepartmentExport implements FromView, WithTitle, WithColumnWidths
{
   public function __construct(public array $data)
   {
   }

   public function view(): View
   {
       return view('exports.department-report', $this->data);
   }
    public function title(): string
    {
        return "Bo'limlar kesimida";
    }

    public function columnWidths(): array
    {
        return [
            'B' => 50,
            'C' => 15,
            'D' => 15,
        ];
    }
}

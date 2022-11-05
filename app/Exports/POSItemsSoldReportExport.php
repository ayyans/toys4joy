<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class POSItemsSoldReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->invoices;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Invoice Number',
            'Quantity',
            'Items'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}

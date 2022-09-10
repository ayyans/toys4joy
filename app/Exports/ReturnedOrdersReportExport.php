<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReturnedOrdersReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    private $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->orders;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order Number',
            'Order Type',
            'Payment Type',
            'Payment Status',
            'Total Items',
            'Total Amount',
            'Returned At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}

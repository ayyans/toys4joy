<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReturnedOrderItemsReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    private $orderItems;

    public function __construct($orderItems)
    {
        $this->orderItems = $orderItems;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->orderItems;
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
            'Product ID',
            'Quantity',
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

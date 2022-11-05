<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class POSRefundsReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $products, $numberOfRefunds, $refundsTotal;

    public function __construct($products, $numberOfRefunds, $refundsTotal)
    {
        $this->products = $products;
        $this->numberOfRefunds = $numberOfRefunds;
        $this->refundsTotal = $refundsTotal;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->products->push(['', '']);
        $this->products->push(['Number of Refunds', $this->numberOfRefunds]);
        $this->products->push(['Refunds Total', $this->refundsTotal]);

        return $this->products;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Invoice Number',
            'Amount',
            'Mode of Payment',
            'Quantity',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class POSSalesReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $products, $numberOfSales, $salesTotal;

    public function __construct($products, $numberOfSales, $salesTotal)
    {
        $this->products = $products;
        $this->numberOfSales = $numberOfSales;
        $this->salesTotal = $salesTotal;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->products->push(['', '']);
        $this->products->push(['Number of Sales', $this->numberOfSales]);
        $this->products->push(['Sales Total', $this->salesTotal]);

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

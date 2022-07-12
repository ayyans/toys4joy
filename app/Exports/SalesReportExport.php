<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $products, $productsSold, $revenueCount;

    public function __construct($products, $productsSold, $revenueCount)
    {
        $this->products = $products;
        $this->productsSold = $productsSold;
        $this->revenueCount = $revenueCount;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->products->push(['', '']);
        $this->products->push(['Products Sold', $this->productsSold]);
        $this->products->push(['Total Revenue', $this->revenueCount]);

        return $this->products;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Sales'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $products, $productsCount, $categoriesCount, $subcategoriesCount;

    public function __construct($products, $productsCount, $categoriesCount, $subcategoriesCount)
    {
        $this->products = $products;
        $this->productsCount = $productsCount;
        $this->categoriesCount = $categoriesCount;
        $this->subcategoriesCount = $subcategoriesCount;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->products->push(['', '']);
        $this->products->push(['Total Products', $this->productsCount]);
        $this->products->push(['Total Categories', $this->categoriesCount]);
        $this->products->push(['Total Subcategories', $this->subcategoriesCount]);

        return $this->products;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'SKU',
            'Price',
            'Stock',
            'Category',
            'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}

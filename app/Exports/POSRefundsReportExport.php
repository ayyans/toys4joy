<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class POSRefundsReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $invoices, $numberOfRefunds, $refundsTotal;

    public function __construct($invoices, $numberOfRefunds, $refundsTotal)
    {
        $this->invoices = $invoices;
        $this->numberOfRefunds = $numberOfRefunds;
        $this->refundsTotal = $refundsTotal;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->invoices->push(['', '']);
        $this->invoices->push(['Number of Refunds', $this->numberOfRefunds]);
        $this->invoices->push(['Refunds Total', $this->refundsTotal]);

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

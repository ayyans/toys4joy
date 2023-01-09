<?php

namespace App\Exports;

use App\Models\ThirdPartyOrder;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ThirdPartyOrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public function __construct(
        private $thirdPartyOrders
    ) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->thirdPartyOrders;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Channel',
            'Order Number',
            'SKU',
            'Quantity',
            'Created On',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }

    /**
    * @var ThirdPartyOrder $thirdPartyOrder
    */
    public function map($thirdPartyOrder): array
    {
        return [
            Str::headline($thirdPartyOrder->channel),
            $thirdPartyOrder->order_number,
            $thirdPartyOrder->sku,
            $thirdPartyOrder->quantity,
            $thirdPartyOrder->created_at
        ];
    }
}

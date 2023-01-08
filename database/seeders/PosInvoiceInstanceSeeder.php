<?php

namespace Database\Seeders;

use App\Models\POSInvoice;
use Illuminate\Database\Seeder;

class PosInvoiceInstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updatedCount = POSInvoice::where('instance', 'pos_products')->update(['instance' => 'pos_product']);
        $updatedCount = POSInvoice::where('instance', 'website_products')->update(['instance' => 'website_product']);
        $this->command->info( sprintf('%d products updated', $updatedCount) );
    }
}

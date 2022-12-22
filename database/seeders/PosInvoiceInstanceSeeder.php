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
        $updatedCount = POSInvoice::whereNull('instance')->update(['instance' => 'pos_products']);
        $this->command->info( sprintf('%d products updated', $updatedCount) );
    }
}

<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
class ImportProducts implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::where('sku' , $row[0])->get()->first();
        if($product)
        {
            $productsave = Product::find($product->id);
            $productsave->unit_price = $row[1];
            $productsave->unit_price = $row[2];
            $productsave->save();
        }
    }
}

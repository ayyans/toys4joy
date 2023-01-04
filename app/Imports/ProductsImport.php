<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Rules\TranslationExists;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithUpserts, WithHeadingRow, WithChunkReading, WithValidation
{
    /**
     * @param  array  $row
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        $category_id = Category::where('category_name->en', $row['category'])->value('id');
        $subcategory_id = SubCategory::where('subcat_name->en', $row['sub_category'])->value('id');
        $brand_id = Brand::where('brand_name', $row['brand'])->value('id');
        return new Product([
            'title' => $row['product_name'],
            'url' => Str::slug( $row['product_name'] ),
            'category_id' => $category_id,
            'sub_cat' => $subcategory_id,
            'brand_id' => $brand_id,
            'barcode' => $row['barcode'],
            'unit_price' => $row['unit_price'],
            'qty' => $row['quantity'],
            'min_qty' => 1,
            'sku' => $row['sku'],
            'long_desc' => $row['long_description'],
        ]);
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'sku';
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required'],
            'category' => ['required', new TranslationExists(Category::class, 'category_name')],
            'sub_category' => ['required', new TranslationExists(SubCategory::class, 'subcat_name')],
            'brand' => ['required', 'exists:brands,brand_name'],
            'barcode' => ['required'],
            'unit_price' => ['required'],
            'quantity' => ['required'],
            'sku' => ['required']
        ];
    }
}

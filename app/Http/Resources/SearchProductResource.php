<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'name' => $this->title,
            'price' => number_format($this->unit_price, 2),
            'image' => asset("products/{$this->featured_img}"),
            'product_url' => route('website.productDetails', ['id' => $this->url])
        ];

        if ($this->category) {
            $result['category'] = $this->category->category_name;
            $result['category_url'] = route('website.cat_products', ['id' => $this->category->url]);
        }

        if ($this->subCategory) {
            $result['subcategory'] = $this->subCategory->subcat_name;
            $result['subcategory_url'] = route('website.subcat_products', ['main' => $this->category->url, 'id' => $this->subCategory->url]);
        }

        $result['categories'] = $this->additional['categories'] ?? [];
        $result['subcategories'] = $this->additional['subCategories'] ?? [];

        return $result;
    }
}

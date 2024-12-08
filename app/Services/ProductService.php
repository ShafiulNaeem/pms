<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPaginateProducts($params)
    {
        $data = Product::orderBy('id', 'desc');
        $data = $this->productFilter($data, $params);
        return $data->paginate(perPage($params));
    }
    public function productFilter($data, $params)
    {
        # search global
        if (isset($params['search']) && $params['search'] != '') {
            $data->where('name', 'like', '%' . $params['search'] . '%')
                ->orWhere('price', 'like', '%' . $params['search'] . '%')
                ->orWhere('stock', 'like', '%' . $params['search'] . '%');
        }
        return $data;
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->getProductById($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->getProductById($id);
        $product->delete();
        return $product;
    }
}

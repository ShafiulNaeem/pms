<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts($params)
    {
        $data = Product::orderBy('id', 'desc');
        # filter
        $data = $this->filterProducts($data, $params);
        return $data->get();
    }
    public function getPaginateProducts(array $params)
    {
        $data = Product::orderBy('id', 'desc');
        # filter
        $data = $this->filterProducts($data, $params);

        return $data->paginate(perPage($params['per_page']));
    }
    public function filterProducts($data, array $params)
    {
        # serach global
        if (isset($params['search']) && $params['search'] != '') {
            $data = $data->where('name', 'like', '%' . $params['search'] . '%')
                ->orWhere('price', 'like', '%' . $params['search'] . '%')
                ->orWhere('stock', 'like', '%' . $params['search'] . '%');
        }

        return $data;
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::find($id);
        $product->update($data);

        return $product;
    }

    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }
}

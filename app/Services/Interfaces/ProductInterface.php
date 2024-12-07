<?php

namespace App\Services\Interfaces;

interface ProductInterface
{
    public function getAllProducts(array $params);
    public function getPaginateProducts(array $params);
    public function filterProducts(array $data, array $params);
    public function getProductById($id);
    public function createProduct(array $data);
    public function updateProduct($id, array $data);
    public function deleteProduct($id);
}
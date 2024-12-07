<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return sendResponse(
            'Products retrieved successfully.',
            $this->productService->getPaginateProducts($request->all()),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            return sendResponse(
                'Product created successfully.',
                $this->productService->createProduct($request->validated()),
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return sendInternalServerError($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return sendResponse(
            'Product retrieved successfully.',
            $this->productService->getProductById($id),
            Response::HTTP_OK
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            return sendResponse(
                'Product updated successfully.',
                $this->productService->updateProduct($id, $request->validated()),
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return sendInternalServerError($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return sendResponse(
                'Product deleted successfully.',
                [],
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return sendInternalServerError($exception);
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OrderRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function store(OrderRequest $request)
    {
        try {
            $data = $request->validated();
            # product stock 
            $product = Product::find($data['product_id']);
            if ($product->stock < $data['quantity']) {
                return sendError(
                    'Product stock is not enough.',
                    [],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            # prepare order data
            $data['total_price'] = $product->price * $data['quantity'];
            $data['user_id'] = auth()->guard('api')->user()->id;
            $order = $this->orderService->createOrder($data);
            # update product stock
            $product->stock = $product->stock - $data['quantity'];
            $product->save();
            return sendResponse(
                'Order created successfully.',
                $order,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return sendInternalServerError($e);
        }
    }
    public function index(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = auth()->guard('api')->user()->id;
        return sendResponse(
            'Orders retrieved successfully.',
            $this->orderService->getPaginateOrders($params),
            Response::HTTP_OK
        );
    }
}

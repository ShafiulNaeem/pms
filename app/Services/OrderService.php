<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    /**
     * Get all orders with pagination
     *  @param $params
     */
    public function getPaginateOrders(array $params)
    {
        $data = Order::with(['user','product'])->orderBy('id', 'desc');
        # filter
        $data = $this->filterOrders($data, $params);

        return $data->paginate(perPage($params));
    }
    /**
     * Filter orders
     * @param $data
     */
    public function filterOrders($data, array $params)
    {
        # serach global
        if (isset($params['search']) && $params['search'] != '') {
            $data = $data->where('quantity', 'like', '%' . $params['search'] . '%')
                ->orWhere('total_price', 'like', '%' . $params['search'] . '%')
                ->orWhere('status', 'like', '%' . $params['search'] . '%');
        }
        # filter by status
        if (isset($params['status']) && $params['status'] != '') {
            $data = $data->where('status', $params['status']);
        }
        # filter by user_id
        if (isset($params['user_id']) && $params['user_id'] != '') {
            $data = $data->where('user_id', $params['user_id']);
        }
        # filter by product_id
        if (isset($params['product_id']) && $params['product_id'] != '') {
            $data = $data->where('product_id', $params['product_id']);
        }

        return $data;
    }

    /**
     * Create order
     * @param $data
     * @return Order
     */
    public function createOrder($data)
    {
        return Order::create($data);
    }
    /**
     * Get order by id
     * @param $id
     * @return Order
     */
    public function getOrderById($id)
    {
        return Order::with(['user','product'])->where('id',$id)->first();
    }
    
}
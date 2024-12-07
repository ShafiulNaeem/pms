<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PaymentRequest;
use App\Models\Payment;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Product;
use App\Services\OrderService;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    private $orderService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Payment initialization
     * @param PaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function pay(PaymentRequest $request)
    {
        try {
            $data =  $this->orderService->getOrderById($request->order_id);
            # process payment
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = Customer::create([
                'name' => $data->user->name,
                'email' => $data->user->email
            ]);
            $product = Product::create([
                'name' => $data->product->name,
                'active' => true,
                'description' => $data->product->description
            ]);

            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => $data->total_price * 100,
                'currency' => 'usd',
            ]);
            # Create a checkout session
            $session = Session::create([
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => $data->quantity
                ]],
                'customer' => $customer->id,
                'mode' => 'payment',
                'success_url' => route('stripe.success', [
                    'order_id' => $request->order_id
                ]),
                'cancel_url' => route('stripe.fail', [
                    'order_id' => $request->order_id
                ]),
                "metadata" => [
                    'order_id' => $request->order_id
                ]
            ]);

            return sendResponse(
                'Payment initialization successfully.',
                ['url' => $session->url],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return sendInternalServerError($e);
        }
    }

    public function success()
    {
        try {
            $order_id = request()->order_id;
            $data = $this->orderService->getOrderById($order_id);
            $data->status = 'paid';
            $data->save();

            # add payment info
            $payment = Payment::create([
                'order_id' => $order_id,
                'product_name' => $data->product->name,
                'amount' => $data->total_price,
                'status' => 'success'
            ]);

            return sendResponse(
                'Payment success.',
                [
                    'order_id' => $order_id,
                    'payment' => $payment,
                    'order' => $data
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return sendInternalServerError($e);
        }
    }

    public function fail()
    {
        try {
            $order_id = request()->order_id;
            return sendResponse(
                'Payment fail.',
                ['order_id' => $order_id],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return sendInternalServerError($e);
        }
    }
}

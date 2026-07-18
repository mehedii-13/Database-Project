<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Repositories\CartRepository;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderRepository $orderRepo;
    protected CartRepository $cartRepo;
    protected SellerRepository $sellerRepo;

    public function __construct(OrderRepository $orderRepo, CartRepository $cartRepo, SellerRepository $sellerRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->cartRepo = $cartRepo;
        $this->sellerRepo = $sellerRepo;
    }

    /**
     * Checkout — convert cart to order.
     */
    public function checkout(Request $request)
    {
        $customerId = session('user_id');
        $cartId = $this->cartRepo->getOrCreateCartForCustomer($customerId);

        try {
            $orderId = $this->orderRepo->createOrderFromCart($customerId, $cartId);
            return redirect("/orders/{$orderId}")->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return redirect('/cart')->with('error', $e->getMessage());
        }
    }

    /**
     * Customer order history.
     */
    public function index()
    {
        $orders = $this->orderRepo->getOrdersByCustomer(session('user_id'));
        return view('orders.index', compact('orders'));
    }

    /**
     * Order detail.
     */
    public function show(int $id)
    {
        $order = $this->orderRepo->getOrderDetails($id);
        if (!$order) abort(404);

        // Customers can only view their own orders
        if (session('role') === 'customer' && $order->customer_id !== session('user_id')) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Seller order view.
     */
    public function sellerOrders()
    {
        $seller = $this->sellerRepo->findByUserId(session('user_id'));
        if (!$seller) {
            return redirect('/seller/register-shop')->with('error', 'Please register your shop first.');
        }

        $orders = $this->orderRepo->getOrdersBySeller($seller->seller_id);
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Admin order view.
     */
    public function adminOrders()
    {
        $orders = $this->orderRepo->getAllOrders();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order status (admin or seller).
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $this->orderRepo->updateStatus($id, $request->input('status'));

        return back()->with('success', 'Order status updated.');
    }
}

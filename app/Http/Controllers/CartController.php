<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartRepository $cartRepo;
    protected ProductRepository $productRepo;

    public function __construct(CartRepository $cartRepo, ProductRepository $productRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * View cart.
     */
    public function index()
    {
        $items = $this->cartRepo->getCartSummary(session('user_id'));
        $total = array_sum(array_map(fn($item) => $item->subtotal, $items));

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = $this->productRepo->findById((int) $request->input('product_id'));
        if (!$product || $product->status === 'out_of_stock') {
            return back()->with('error', 'Product is not available.');
        }

        $cartId = $this->cartRepo->getOrCreateCartForCustomer(session('user_id'));
        $this->cartRepo->addItem($cartId, (int) $request->input('product_id'), (int) $request->input('quantity', 1));

        return redirect('/cart')->with('success', "\"{$product->name}\" added to cart!");
    }

    /**
     * Update item quantity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer',
            'quantity'     => 'required|integer|min:0',
        ]);

        $this->cartRepo->updateQuantity(
            (int) $request->input('cart_item_id'),
            (int) $request->input('quantity')
        );

        return redirect('/cart')->with('success', 'Cart updated.');
    }

    /**
     * Remove item from cart.
     */
    public function remove(int $id)
    {
        $this->cartRepo->removeItem($id);
        return redirect('/cart')->with('success', 'Item removed from cart.');
    }
}

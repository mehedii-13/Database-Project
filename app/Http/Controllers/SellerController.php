<?php

namespace App\Http\Controllers;

use App\Repositories\SellerRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    protected SellerRepository $sellerRepo;

    public function __construct(SellerRepository $sellerRepo)
    {
        $this->sellerRepo = $sellerRepo;
    }

    /**
     * Show shop registration form.
     */
    public function showRegisterShopForm(Request $request)
    {
        // Check if seller already has a shop
        $seller = $this->sellerRepo->findByUserId(session('user_id'));
        if ($seller) {
            return redirect('/seller/products')->with('info', 'You already have a shop registered.');
        }

        return view('seller.register_shop');
    }

    /**
     * Handle shop registration.
     */
    public function registerShop(Request $request)
    {
        $request->validate([
            'shop_name'        => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:2000',
        ]);

        // Check if seller already has a shop
        $seller = $this->sellerRepo->findByUserId(session('user_id'));
        if ($seller) {
            return redirect('/seller/products')->with('error', 'You already have a shop.');
        }

        $this->sellerRepo->createShop(
            session('user_id'),
            $request->input('shop_name'),
            $request->input('shop_description')
        );

        return redirect('/seller/products')->with('success', 'Your shop has been created!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    protected ProductRepository $productRepo;
    protected BrandRepository $brandRepo;
    protected CategoryRepository $categoryRepo;
    protected SellerRepository $sellerRepo;

    public function __construct(
        ProductRepository $productRepo,
        BrandRepository $brandRepo,
        CategoryRepository $categoryRepo,
        SellerRepository $sellerRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sellerRepo = $sellerRepo;
    }

    /**
     * Get the seller record for the logged-in user, or redirect to shop registration.
     */
    private function getSeller()
    {
        $seller = $this->sellerRepo->findByUserId(session('user_id'));
        if (!$seller) {
            return null;
        }
        return $seller;
    }

    /**
     * List seller's products.
     */
    public function index()
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop')->with('error', 'Please register your shop first.');
        }

        $products = $this->productRepo->listBySeller($seller->seller_id);
        return view('seller.products.index', compact('products', 'seller'));
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop')->with('error', 'Please register your shop first.');
        }

        $brands = $this->brandRepo->all();
        $categories = $this->categoryRepo->all();
        return view('seller.products.create', compact('brands', 'categories'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer',
            'brand_id'    => 'required|integer',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:5000',
        ]);

        $this->productRepo->create(
            $seller->seller_id,
            (int) $request->input('category_id'),
            (int) $request->input('brand_id'),
            $request->input('name'),
            (float) $request->input('price'),
            (int) $request->input('stock'),
            $request->input('description')
        );

        return redirect('/seller/products')->with('success', 'Product created!');
    }

    /**
     * Show edit product form.
     */
    public function edit(int $id)
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop');
        }

        $product = $this->productRepo->findById($id);
        if (!$product || $product->seller_id !== $seller->seller_id) {
            abort(403);
        }

        $brands = $this->brandRepo->all();
        $categories = $this->categoryRepo->all();
        return view('seller.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, int $id)
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop');
        }

        $product = $this->productRepo->findById($id);
        if (!$product || $product->seller_id !== $seller->seller_id) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer',
            'brand_id'    => 'required|integer',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:5000',
        ]);

        $this->productRepo->update(
            $id,
            (int) $request->input('category_id'),
            (int) $request->input('brand_id'),
            $request->input('name'),
            (float) $request->input('price'),
            (int) $request->input('stock'),
            $request->input('description')
        );

        return redirect('/seller/products')->with('success', 'Product updated!');
    }

    /**
     * Delete a product.
     */
    public function destroy(int $id)
    {
        $seller = $this->getSeller();
        if (!$seller) {
            return redirect('/seller/register-shop');
        }

        $product = $this->productRepo->findById($id);
        if (!$product || $product->seller_id !== $seller->seller_id) {
            abort(403);
        }

        $this->productRepo->delete($id);
        return redirect('/seller/products')->with('success', 'Product deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductRepository $productRepo;
    protected BrandRepository $brandRepo;
    protected CategoryRepository $categoryRepo;
    protected ReviewRepository $reviewRepo;

    public function __construct(
        ProductRepository $productRepo,
        BrandRepository $brandRepo,
        CategoryRepository $categoryRepo,
        ReviewRepository $reviewRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->reviewRepo = $reviewRepo;
    }

    /**
     * Public product listing with search, filter, sort, pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category') ? (int) $request->input('category') : null;
        $brandId = $request->input('brand') ? (int) $request->input('brand') : null;
        $sortBy = $request->input('sort', 'newest');
        $sortDir = $request->input('dir', 'DESC');
        $page = max(1, (int) $request->input('page', 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $products = $this->productRepo->browse($search, $categoryId, $brandId, $sortBy, $sortDir, $perPage, $offset);
        $totalCount = $this->productRepo->countBrowse($search, $categoryId, $brandId);
        $totalPages = (int) ceil($totalCount / $perPage);

        $categories = $this->categoryRepo->all();
        $brands = $this->brandRepo->all();

        return view('products.index', compact(
            'products', 'categories', 'brands',
            'search', 'categoryId', 'brandId', 'sortBy', 'sortDir',
            'page', 'totalPages', 'totalCount'
        ));
    }

    /**
     * Product detail page.
     */
    public function show(int $id)
    {
        $product = $this->productRepo->findById($id);
        if (!$product) abort(404);

        $reviews = $this->reviewRepo->getByProduct($id);
        $avgRating = $this->reviewRepo->getAverageRating($id);

        $canReview = false;
        $hasReviewed = false;
        if (session('role') === 'customer' && session('user_id')) {
            $canReview = $this->reviewRepo->hasPurchased(session('user_id'), $id);
            $hasReviewed = $this->reviewRepo->hasReviewed(session('user_id'), $id);
        }

        return view('products.show', compact('product', 'reviews', 'avgRating', 'canReview', 'hasReviewed'));
    }
}

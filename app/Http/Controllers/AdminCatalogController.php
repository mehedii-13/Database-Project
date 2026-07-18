<?php

namespace App\Http\Controllers;

use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class AdminCatalogController extends Controller
{
    protected BrandRepository $brandRepo;
    protected CategoryRepository $categoryRepo;

    public function __construct(BrandRepository $brandRepo, CategoryRepository $categoryRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    // ── Brands ──

    public function brandsIndex()
    {
        $brands = $this->brandRepo->all();
        return view('admin.brands.index', compact('brands'));
    }

    public function brandsCreate()
    {
        return view('admin.brands.create');
    }

    public function brandsStore(Request $request)
    {
        $request->validate(['brand_name' => 'required|string|max:255']);
        $this->brandRepo->create($request->input('brand_name'));
        return redirect('/admin/brands')->with('success', 'Brand created successfully.');
    }

    public function brandsEdit(int $id)
    {
        $brand = $this->brandRepo->findById($id);
        if (!$brand) abort(404);
        return view('admin.brands.edit', compact('brand'));
    }

    public function brandsUpdate(Request $request, int $id)
    {
        $request->validate(['brand_name' => 'required|string|max:255']);
        $this->brandRepo->update($id, $request->input('brand_name'));
        return redirect('/admin/brands')->with('success', 'Brand updated successfully.');
    }

    public function brandsDestroy(int $id)
    {
        $this->brandRepo->delete($id);
        return redirect('/admin/brands')->with('success', 'Brand deleted.');
    }

    // ── Categories ──

    public function categoriesIndex()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        $this->categoryRepo->create($request->input('category_name'));
        return redirect('/admin/categories')->with('success', 'Category created successfully.');
    }

    public function categoriesEdit(int $id)
    {
        $category = $this->categoryRepo->findById($id);
        if (!$category) abort(404);
        return view('admin.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, int $id)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        $this->categoryRepo->update($id, $request->input('category_name'));
        return redirect('/admin/categories')->with('success', 'Category updated successfully.');
    }

    public function categoriesDestroy(int $id)
    {
        $this->categoryRepo->delete($id);
        return redirect('/admin/categories')->with('success', 'Category deleted.');
    }
}

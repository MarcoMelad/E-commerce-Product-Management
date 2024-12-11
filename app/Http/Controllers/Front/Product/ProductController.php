<?php

namespace App\Http\Controllers\Front\Product;

use App\Http\Controllers\Controller;
use App\Services\Front\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    public function index(Request $request)
    {
        $result = $this->productService->productList($request->all())['data'];
        return view('front.products.index', with($result));
    }

    public function create()
    {
        return view('front.products.create');
    }
    public function store(Request $request)
    {
        $result = $this->productService->createProduct($request->all());

        if (isset($result['errors'])) {
            return redirect()->back()->withErrors($result['errors']);
        }
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $result = $this->productService->editProduct($id)['data'];
        return view('front.products.edit', with($result));
    }
    public function update(Request $request, $id)
    {
        $result = $this->productService->updateProduct($request->all(), $id);
        if (isset($result['errors'])) {
            return redirect()->back()->withErrors($result['errors']);
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy(string $id)
    {
        $result = $this->productService->deleteProduct($id);

        if (isset($result['errors'])) {
            return redirect()->back()->withErrors($result['errors']);
        }
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

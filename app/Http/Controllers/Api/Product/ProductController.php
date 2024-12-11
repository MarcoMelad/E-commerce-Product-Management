<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ProductStoreRequest;
use App\Services\Api\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    public function index(Request $request): JsonResponse
    {
        $result = $this->productService->productList($request->all());
        return response()->json($result, $result['status_code']);
    }
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $result = $this->productService->createProduct($request->validated());
        return response()->json($result, $result['status_code']);
    }
    public function show($id): JsonResponse
    {
        $result = $this->productService->productDetail($id);
        return response()->json($result, $result['status_code']);
    }
    public function update(ProductStoreRequest $request, $id): JsonResponse
    {
        $result = $this->productService->updateProduct($request->validated(), $id);
        return response()->json($result, $result['status_code']);
    }
    public function destroy(string $id): JsonResponse
    {
        $result = $this->productService->deleteProduct($id);
        return response()->json($result, $result['status_code']);
    }
}

<?php

namespace App\Services\Api\Product;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class ProductService extends BaseService
{
    public function productList(array $data): array
    {
        $validator = validator($data, [
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'per_page' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->failed(400, ['error' => $validator->errors()->first()]);
        }
        $products = Product::query();

        if (!empty($data['name'])) {
            $products = $products->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (!empty($data['price'])) {
            $products = $products->where('price', $data['price']);
        }
        $products = $products->paginate($data['per_page'] ?? 10);
        return $this->success(200, ['products' => ProductResource::collection($products)]);
    }
    public function productDetail($id): array
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->failed(404, ['error' => 'product not found']);
        }

        return $this->success(200, ['product' => new ProductResource($product)]);
    }

    public function createProduct(array $data): array
    {
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->quantity = $data['quantity'];
        $product->save();

        return $this->success(200, ['product' => new ProductResource($product)]);
    }

    public function updateProduct(array $data, $id): array
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->failed(404, ['error' => 'product not found']);
        }

        $product->name = $data['name'] ?? $product->name;
        $product->description = $data['description'] ?? $product->description;
        $product->price = $data['price'] ?? $product->price;
        $product->quantity = $data['quantity'] ?? $product->quantity;
        $product->save();

        return $this->success(200, ['product' => new ProductResource($product)]);
    }
    public function deleteProduct($id): array
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->failed(404, ['error' => 'product not found']);
        }
        $product->delete();
        return $this->success(200, ['message' => 'product deleted successfully']);
    }
}

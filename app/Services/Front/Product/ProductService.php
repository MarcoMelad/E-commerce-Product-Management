<?php

namespace App\Services\Front\Product;

use App\Models\Product;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductService extends BaseService
{
    public function productList(array $data): array
    {
        $validator = validator($data, [
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
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
        return $this->success(200, ['products' => $products]);
    }
    public function createProduct(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->failed(400, $validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();
            $product = new Product();
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->quantity = $data['quantity'];
            $product->save();

            DB::commit();
            return $this->success(200, ['success' => 'Product added successfully!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failed(500, ['error' => $exception->getMessage()]);
        }
    }
    public function editProduct($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return $this->failed(404, ['error' => 'Product not found!']);
        }
        return $this->success(200, ['product' => $product]);
    }
    public function updateProduct(array $data, $id): array
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->failed(404, ['error' => 'Product not found']);
        }

        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->failed(400, $validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $product->name = $data['name'] ?? $product->name;
            $product->description = $data['description'] ?? $product->description;
            $product->price = $data['price'] ?? $product->price;
            $product->quantity = $data['quantity'] ?? $product->quantity;
            $product->save();

            DB::commit();
            return $this->success(200, ['success' => 'Product updated successfully!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failed(500, ['error' => $exception->getMessage()]);
        }
    }
    public function deleteProduct($id): array
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->failed(404, ['error' => 'product not found']);
        }
        $product->delete();
        return $this->success(200, ['success' => 'product deleted successfully']);
    }
}

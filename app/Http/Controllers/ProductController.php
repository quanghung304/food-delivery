<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    private $productModel;
    private $categoryModel;
    /**
     * @param $productModel
     */
    public function __construct(
        Product $productModel,
        Category $categoryModel
    ) {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    public function createProduct(Request $request)
    {
        $checkExist = $this->productModel->getProductByName($request->name);
        if($checkExist) {
            return response()->json([
                'message' => 'Product is existed'
            ], 409);
        }

        $checkExist = $this->categoryModel->find($request->category_id);
        if(!$checkExist) {
            return response()->json([
                'message' => 'Category is not existed'
            ], 409);
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'category_id' => $request->category_id,
            'image' => $request->image ?? '',
            'size' => $request->size ?? '',
            'price' => $request->price
        ];
        $this->productModel->create($data);

        return response()->json([
        ], 200);
    }

    public function getAll()
    {
        $data = $this->productModel->get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function getDetail($id)
    {
        $product = $this->productModel->find($id);
        return response()->json([
            'data' => $product
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = $this->productModel->find($id);

        $data = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'category_id' => $request->category_id,
            'image' => $request->image ?? '',
            'size' => $request->size ?? '',
            'price' => $request->price
        ];
        $product->update($data);

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete($id);
        return response()->json([
        ], 200);
    }
}

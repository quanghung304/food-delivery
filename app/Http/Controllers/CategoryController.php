<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    private $categoryModel;

    /**
     * @param $categoryModel
     */
    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function create(Request $request)
    {
        $checkExist = $this->categoryModel->getCategoryByName($request->category_name);
        if($checkExist) {
            return response()->json([
                'message' => 'Category is existed'
            ], 409);
        }
        $data = [
            'category_name' => $request->category_name
        ];
        $this->categoryModel->create($data);

        return response()->json([
        ], 200);
    }

    public function getCategoryList(Request $request)
    {
        $data = $this->categoryModel->get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $data = [
            'category_name' => $request->category_name
        ];
        $category->update($data);

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function deleteCategory(Request $request, $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete($id);
        return response()->json([
        ], 200);
    }
}

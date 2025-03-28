<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    // 
    public function index(Request $request): JsonResponse {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'ILIKE', "%{$request->query('name')}%");
        }
        if ($request->has('category')) {
            $query->where('category', $request->query('category'));
        }
        if ($request->has('price')) {
            $query->where('price', '<=', $request->query('price'));
        }

        $products = $query->paginate(10);
        return response()->json($products);
    }


    public function store(Request $request): JsonResponse {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description'=>'nullable|string', 
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ]);

        $product = Product::create($data);
        return response()->json($product, 201);
    }


    public function show($id): JsonResponse {
        $product = Product::find($id);

        if(!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($product);
    }


    public function update(Request $request, $id): JsonResponse {
        $product = Product::find($id);

        if(!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'category' => 'sometimes|string|max:255',
        ]);

        $product->update($data);
        return response()->json($product);
    }


    public function delete($id): JsonResponse {
        $product = Product::find($id);

        if(!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produto deletado com sucesso']);
    }
}

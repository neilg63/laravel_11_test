<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $start = 0;
        $limit = 50;
        if ($request->has('start')) {
            $start = (int) $request->get('start');
        }
        if ($request->has('limit')) {
            $limit = (int) $request->get('limit');
        }
        $users = Product::limit($limit)->offset($start)->get();
        
        return response()->json([
            'start' => $start,
            'limit' => $limit,
            'users' => $users,
        ]);
    }

    public function show(Request $request, int $id = 0)
    {
        $product = $id > 0 ? Product::find($id) : null;
        $valid = $product instanceof Product;
        return response()->json([
            'product' => $product,
            'valid'     => $valid,
        ]);
    }

    public function create(Request $request)
    {
        $payload = $request->json()->all();
        
        if (count($payload) > 4) {
            $product = Product::create($payload);
            $valid = $product instanceof Product;
        }
        return response()->json([
            'product'     => $product,
            'valid'     => $valid,
        ]);
    }


    public function update(Request $request, int $id = 0)
    {
        $product = $id > 0 ? Product::find($id) : null;
        $valid = $product instanceof Product;
        if ($valid) {
            $payload = $request->json()->all();
            $product->update($payload);
        }
        return response()->json([
            'product' => $product,
            'valid'     => $valid,
        ]);
    }

}

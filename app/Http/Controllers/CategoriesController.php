<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'status' => 'ok',
                'payload' => $categories
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $category = Category::where('id', $id)->first();

            if (empty($category)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'payload' => $category
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $slug = '';

        try {
            $category = Category::create([
                'name' => $name,
                'slug' => $slug
            ]);

            return response()->json([
                'status' => 'ok',
                'payload' => $category
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        try {
            $updated = Category::where('id', $id)
                ->update([
                    'name' => $name
                ]);

            if ($updated < 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'status' => 'ok'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        try {
            $deleted = Category::where('id', $id)->delete();

            if (empty($deleted)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'status' => 'ok'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }
}

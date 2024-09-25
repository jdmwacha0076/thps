<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    //For fetching data from the API in JSON format
    private function fetchRawData()
    {
        $url = 'https://dummyjson.com/products';
        $response = file_get_contents($url);

        return $response !== false ? json_decode($response, true) : null;
    }

    public function JSONRawData()
    {

        $cacheKey = 'products';
        $cacheDuration = 10 * 60;

        $products = Cache::remember($cacheKey, $cacheDuration, function () {
            return $this->fetchRawData();
        });

        if ($products) {
            return response()->json(['status' => 'success', 'data' => $products['products']]);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to fetch data...!!!'], 500);
    }

    //For displaying products from the API in table form
    public function showAPIProducts()
    {
        $cacheKey = 'products';
        $products = Cache::get($cacheKey);

        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Failed to fetch data...!!!');
        }

        return view('api-products', ['products' => $products['products']]);
    }

    //For searching products from the API data
    public function searchAPIProducts(Request $request)
    {
        $query = $request->input('query');

        $cacheKey = 'products';
        $products = Cache::get($cacheKey);

        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Failed to fetch data...!!!');
        }

        $filteredProducts = array_filter($products['products'], function ($product) use ($query) {
            return stripos($product['title'], $query) !== false;
        });

        return view('api-products', ['products' => $filteredProducts]);
    }

    //For filtering products from the API data
    public function filterAPIProducts(Request $request)
    {
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $cacheKey = 'products';
        $products = Cache::get($cacheKey);

        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Failed to fetch data...!!!');
        }

        $filteredProducts = array_filter($products['products'], function ($product) use ($category, $minPrice, $maxPrice) {
            $matchesCategory = !$category || $product['category'] === $category;
            $matchesPrice = (!$minPrice || $product['price'] >= $minPrice) && (!$maxPrice || $product['price'] <= $maxPrice);
            return $matchesCategory && $matchesPrice;
        });

        return view('api-products', ['products' => $filteredProducts]);
    }

    //For showing all products from the API data
    public function showProducts()
    {
        $cacheKey = 'products';
        $products = Cache::get($cacheKey);

        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Failed to fetch products.');
        }

        return view('product-details', ['products' => $products['products']]);
    }

    //For showing the product detailed data
    public function showProductDetails($id)
    {

        $product = Cache::remember("product_$id", 10 * 60, function () use ($id) {
            $response = Http::get("https://dummyjson.com/products/$id");

            if ($response->successful()) {
                return $response->json();
            } else {
                abort(404, 'Product not found.');
            }
        });

        return view('details-per-product', compact('product'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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

    //For fetching data from the API and store into the database
    public function fetchAndStoreProducts()
    {
        $response = Http::get('https://dummyjson.com/products');

        if ($response->successful()) {
            $products = $response->json()['products'];

            $newProducts = [];
            foreach ($products as $product) {
                $existingProduct = Product::find($product['id']);

                if (!$existingProduct) {
                    $newProducts[] = [
                        'id' => $product['id'],
                        'title' => $product['title'],
                        'price' => $product['price'],
                        'description' => $product['description'],
                        'category' => $product['category'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($newProducts)) {
                Product::insert($newProducts);
                return redirect()->route('update-product-details')->with('success', 'New products fetched and stored locally.');
            } else {
                return redirect()->route('update-product-details')->with('error', 'No new products to fetch.');
            }
        }

        return redirect()->route('update-product-details')->with('error', 'Failed to products...!!!');
    }

    //For viewing the fetched data and update price
    public function viewUpdateProductDetails()
    {
        $products = Product::all();
        return view('update-product-details', compact('products'));
    }

    //For updating a price for a product
    public function updatePoductPrice(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        $product = Product::find($request->input('product_id'));
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('update-product-details')->with('success', 'Product price updated.');
    }

    //For complex query filtering
    public function ComplexQuerying(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->input('search') != '') {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('price', $request->input('sort'));
        }

        $products = $query->get();

        return view('complex-querying', compact('products'));
    }
}

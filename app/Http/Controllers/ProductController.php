<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    //For fetching data from the API in JSON format
    private function fetchRawData()
    {
        $url = env('PRODUCTS_API_URL');
        $response = @file_get_contents($url);

        if ($response === false) {
            Log::error('Failed to fetch data, see the error here: ' . $url);
            return null;
        }
        return json_decode($response, true);
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
            $response = Http::get(env('PRODUCTS_API_URL') . "/$id");

            if ($response->failed()) {
                abort(404, 'Product not found.');
            }

            return $response->json();
        });

        return view('details-per-product', compact('product'));
    }

    //For fetching data from the API and store into the database
    public function fetchAndStoreProducts()
    {
        $response = Http::get(env('PRODUCTS_API_URL'));

        if ($response->successful()) {
            Log::error('Failed to fetch products from the API: ' . $response->status());
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
                return redirect()->route('update-product-details')->with('success', 'New products fetched from th e API and stored in MYSQL database.');
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

        return redirect()->route('update-product-details')->with('success', 'Completed updating the product price.');
    }

    //For deleting a product in MYSQL database
    public function deleteProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));

        if ($product) {
            $product->delete();
            return redirect()->route('update-product-details')->with('success', 'Product deleted .');
        }

        return redirect()->route('update-product-details')->with('error', 'Failed to delete the product.');
    }

    //For complex query filtering
    public function ComplexQuerying(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'category' => 'nullable|string|in:furniture,groceries,fragrances,beauty',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort' => 'nullable|string|in:asc,desc',
        ]);

        $query = Product::query();

        if ($request->has('search') && $request->input('search') != '') {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('min_price') && $request->input('min_price') !== null) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price') && $request->input('max_price') !== null) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('price', $request->input('sort'));
        }

        $products = $query->get();

        return view('complex-querying', compact('products'));
    }
}

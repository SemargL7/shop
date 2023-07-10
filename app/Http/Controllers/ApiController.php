<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllCategories()
    {
        $data = [
            'key' => getenv('CRM_SECRET_KEY'),
        ];

        // Request categories
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://romandubil.lp-crm.biz/api/getCategories.html',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Check if the request was successful
        if ($response === false) {
            return response()->json(['error' => 'Failed to retrieve categories'], 500);
        }

        // Decode the JSON response
        $categories = json_decode($response, true);

        // Check if JSON decoding was successful
        if ($categories === null) {
            return response()->json(['error' => 'Failed to parse JSON response'], 500);
        }

        return response()->json($categories);
    }
    public function getProductsByCategory(Request $request)
    {
        // Fetch products based on the $category_id
        // You can modify the getAllProducts function to filter products by the provided $category_id

        $category_id = $request->input('category_id');
        $data = array(
            'key' => getenv('CRM_SECRET_KEY'), // Your secret token
            'category_id' => $category_id
        );

        // Make the API request to get products by category
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/getProductsByCategory.html');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($out, true);

        if ($response && $response['status'] === 'ok') {
            $products = $response['data'];
            return response()->json($products);
        } else {
            return response()->json([]);
        }
    }

    public function getItemsByCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        $items = Item::where('item_category_id', $category_id)
            ->paginate(10);

        foreach ($items as $item) {
            $image = Image::where('item_id', $item->id)->first();

            if ($image) {
                $item->image = $image;
                $item->image->image = base64_encode($image->image);
            } else {
                $item->image = null;
            }
        }

        $responseData = json_encode(['items' => $items], JSON_UNESCAPED_UNICODE);
        return response($responseData)->header('Content-Type', 'application/json');
    }
}

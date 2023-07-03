<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Image;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function getProductsByCategory($category_id)
    {
        // Fetch products based on the $category_id
        // You can modify the getAllProducts function to filter products by the provided $category_id

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

    public function getItemsByCategory($category_id)
    {
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

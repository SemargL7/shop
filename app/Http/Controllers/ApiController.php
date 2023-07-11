<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use App\Services\CrmService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllCategories()
    {
        return CrmService::getCategories();
    }
    public function getProductsByCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        return CrmService::getProductsByCategory($category_id);
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

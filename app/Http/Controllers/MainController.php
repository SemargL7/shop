<?php

namespace App\Http\Controllers;

use App\Models\Characteristics;
use App\Models\Image;
use App\Models\Item;
use App\Models\ItemsInfo;
use App\Models\Role;
use App\Models\UserRole;
use App\Services\CrmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $filter = $request->input('filter');
        $categories = $request->input('categories');

        $query = Item::query();

        if ($categories) {
            $categoryIds = is_array($categories) ? $categories : [$categories];
            $query->whereIn('item_category_id', $categoryIds);
        }

        if ($filter) {
            $query->where('item_name', 'like', '%' . $filter . '%');
        }

        $items = $query->paginate(10);

        foreach ($items as $item) {
            $image = Image::where('item_id', $item->id)->first();

            if ($image) {
                $item->image = $image;
                $item->image->image = $image->image;
            } else {
                $item->image = null;
            }
        }

        return view('home', compact('items'));
    }

    function itemView(Request $request, $item_number)
    {
        (new CrmService)->Utm();

        $item = Item::where('item_number',$item_number)->first();

        if($item != null){
            $item_info = ItemsInfo::where('item_id', $item->id)->first();
            $images = Image::where('item_id', $item->id)->get();
            $characteristics = Characteristics::where('item_id', $item->id)->get();

            $response = (new CrmService)->getProductById($item->item_crm_id);

            $product_price = $response['price'] ?? 0;

            return view('itemView',[
                'item'=> $item,
                'item_info' => $item_info,
                'images' => $images,
                'characteristics' => $characteristics,
                'product_price' => $product_price
            ]);
        }
        else{
            return redirect()->back();
        }

    }

    public function profilePage(){
        $user_id = Auth::user()->id;
        $user_role = UserRole::where('user_id',$user_id)->first();
        $role = Role::where('id',$user_role->role_id)->first();
        return view('profile', [
            'user_role' => $role
        ]);
    }

    function privacyPolicyPage()
    {
        return view('legal.privacyPolicy');
    }

    function termsOfUsePage()
    {
        return view('legal.termsOfUse');
    }
}

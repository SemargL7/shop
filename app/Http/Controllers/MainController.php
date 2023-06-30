<?php

namespace App\Http\Controllers;

use App\Models\Characteristics;
use App\Models\Image;
use App\Models\Item;
use App\Models\Items_info;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function home()
    {
        $items = Item::all();
        $images = Image::all();

        return view('home', [
            'items' => $items,
            'images' => $images
        ]);
    }

    function itemView($item_number)
    {
        $item = Item::where('item_number',$item_number)->first();
        if($item != null){
            $item_info = Items_info::where('item_id', $item->id)->first();
            $images = Image::where('item_id', $item->id)->get();
            $characteristics = Characteristics::where('item_id', $item->id)->get();
            return view('itemView',[
                'item'=> $item,
                'item_info' => $item_info,
                'images' => $images,
                'characteristics' => $characteristics
            ]);
        }
        else{
            return redirect()->back();
        }

    }


}

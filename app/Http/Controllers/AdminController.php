<?php

namespace App\Http\Controllers;

use App\Models\Characteristics;
use App\Models\Image;
use App\Models\Item;
use App\Models\ItemsInfo;
use App\Services\CrmService;
use Illuminate\Http\Request;
use League\CommonMark\Extension\DescriptionList\Node\Description;

class AdminController extends Controller
{
    public function createNewItem(Request $request)
    {
        $valid = $request->validate([
            'item_name' => 'required|string',
            'item_number' => 'required|string',
            'item_facebook_pixel' => 'required|string',
            'item_crm_id' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'howtouse' => 'required|string',
            'image.*' => 'required|mimes:jpeg,png'
        ]);

        $item = new Item();
        $item->item_name = $request->input('item_name');
        $item->item_number = $request->input('item_number');
        $item->item_facebook_pixel = $request->input('item_facebook_pixel');
        $item->item_crm_id = $request->input('item_crm_id');
        $item->item_category_id = $request->input('category_id');
        $item->save();

        $item_info = new ItemsInfo();
        $item_info->description = $request->input('description');
        $item_info->howtouse = $request->input('howtouse');
        $item_info->item_id = $item->id; // Assign the item_id to the item_info
        $item_info->save();

        if ($request->has('characteristics')) {
            $characteristics = $request->input('characteristics');
            $values = $request->input('value');
            $data = array();
            foreach ($characteristics as $index => $characteristic) {
                $value = $values[$index];
                $data[] = ['characteristics' => $characteristic, 'value' => $value];
            }
            foreach ($data as $char) {
                $characteristicsModel = new Characteristics();
                $characteristicsModel->name = $char['characteristics']; // Access the array values using square brackets
                $characteristicsModel->value = $char['value']; // Access the array values using square brackets
                $characteristicsModel->item_id = $item->id;
                $characteristicsModel->save(); // Invoke the save method
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $imageData = file_get_contents($file);

                $imageSize = $file->getSize();
                $imageType = $file->getClientMimeType();

                $position = strpos($name, '.');
                $imageCategory = ($position !== false) ? substr($name, $position + 1) : 'bin';

                try {
                    $imageModel = new Image();
                    $imageModel->image_type = $imageType;
                    $imageModel->image = $imageData;
                    $imageModel->image_size = $imageSize;
                    $imageModel->image_ctgy = $imageCategory;
                    $imageModel->image_name = $name;
                    $imageModel->item_id = $item->id;
                    $imageModel->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    // Log or display the error message
                    dd($e->getMessage());
                }
            }
        }

        return redirect()->back();
    }


    public function updateItem(Request $request)
    {
        $valid = $request->validate([
            'item_name' => 'required|string',
            'item_number' => 'required|string',
            'item_facebook_pixel' => 'required|string',
            'item_crm_id' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'howtouse' => 'required|string',
            'image.*' => 'required|mimes:jpeg,png'
        ]);

        $itemId = $request->input('item_id');

        $item = Item::findOrFail($itemId);
        $item->item_name = $request->input('item_name');
        $item->item_number = $request->input('item_number');
        $item->item_facebook_pixel = $request->input('item_facebook_pixel');
        $item->item_crm_id = $request->input('item_crm_id');
        $item->save();

        $item_info = ItemsInfo::where('item_id', $itemId)->first();
        $item_info->description = $request->input('description');
        $item_info->howtouse = $request->input('howtouse');
        $item_info->save();

        if ($request->has('characteristics')) {
            Characteristics::where('item_id', $itemId)->delete();
            $characteristics = $request->input('characteristics');
            $values = $request->input('value');
            $data = array();
            foreach ($characteristics as $index => $characteristic) {
                $value = $values[$index];
                $data[] = ['characteristics' => $characteristic, 'value' => $value];
            }

            Characteristics::where('item_id', $itemId)->delete();

            foreach ($data as $char) {
                $characteristicsModel = new Characteristics();
                $characteristicsModel->name = $char['characteristics'];
                $characteristicsModel->value = $char['value'];
                $characteristicsModel->item_id = $itemId;
                $characteristicsModel->save();
            }
        }

        if ($request->hasFile('image')) {
            $existingImages = Image::where('item_id', $itemId)->get();

            foreach ($existingImages as $existingImage) {
                $existingImage->delete();
            }

            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $imageData = file_get_contents($file);

                $imageSize = $file->getSize();
                $imageType = $file->getClientMimeType();

                $position = strpos($name, '.');
                $imageCategory = ($position !== false) ? substr($name, $position + 1) : 'bin';

                try {
                    $imageModel = new Image();
                    $imageModel->image_type = $imageType;
                    $imageModel->image = $imageData;
                    $imageModel->image_size = $imageSize;
                    $imageModel->image_ctgy = $imageCategory;
                    $imageModel->image_name = $name;
                    $imageModel->item_id = $itemId;
                    $imageModel->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    // Log or display the error message
                    dd($e->getMessage());
                }
            }
        }
        if ($request->has('delete_image')) {
            $deleteImages = $request->input('delete_image');
            Image::whereIn('id', $deleteImages)->delete();
        }

        return redirect()->route('itemsList');
    }


    function createNewItemPage()
    {

        return view('admin.createNewItem', ['categories' => (new CrmService)->getCategories()]);
    }
    function editItemPage(Request $request) {
        $item_id = $request->input('item_id');
        $item = Item::where('id', $item_id)->first();
        $images = Image::where('item_id', $item_id)->get();
        $characteristics = Characteristics::where('item_id', $item_id)->get();
        $item_info = ItemsInfo::where('item_id', $item_id)->first();

        return view('admin.editItem', [
            'item' => $item,
            'images' => $images,
            'characteristics' => $characteristics,
            'item_info' => $item_info
        ]);
    }

    function deleteItem(Request $request)
    {
        Item::destroy('id', $request->input('item_id'));
        return redirect()->back();
    }

    public function switchActiveShowStatusItem(Request $request){
        $valid = $request->validate([
            'item_id' => 'required|integer',
            'active' => 'required|boolean',
        ]);
        $itemId = $request->input('item_id');
        $active_status = $request->input('active');
        $item = Item::find($itemId);
        $item->active = !$active_status;
        $item->save();
        return redirect()->back();
    }

    function itemsList(Request $request)
    {
        $query = Item::query();

        // Filter items based on criteria
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query->where('item_name', 'like', '%' . $filter . '%')
                ->orWhere('item_number', 'like', '%' . $filter . '%');
        }

        $items = $query->paginate(10)->withQueryString();

        return view('admin.itemsList', [
            'items' => $items,
            'filter' => $request->input('filter')
        ]);
    }
}

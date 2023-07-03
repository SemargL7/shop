<?php

namespace App\Http\Controllers;

use App\Models\Characteristics;
use App\Models\Image;
use App\Models\Item;
use App\Models\ItemsInfo;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $filter = $request->input('filter');

        $items = Item::with('images')
            ->when($filter, function ($query, $filter) {
                return $query->where('item_name', 'like', '%' . $filter . '%');
            })
            ->paginate(10);

        return view('home', compact('items'));
    }

    function itemView(Request $request, $item_number)
    {
        $period_cookie = 2592000;

        // Handle the request
        if ($request->has('utm_source')) {
            // Set the cookies
            Cookie::queue('utm_source', $request->input('utm_source'), $period_cookie);
            Cookie::queue('utm_medium', $request->input('utm_medium'), $period_cookie);
            Cookie::queue('utm_term', $request->input('utm_term'), $period_cookie);
            Cookie::queue('utm_content', $request->input('utm_content'), $period_cookie);
            Cookie::queue('utm_campaign', $request->input('utm_campaign'), $period_cookie);
        }

        // Initialize the session data if it doesn't exist
        if (!Session::has('utms')) {
            Session::put('utms', [
                'utm_source' => '',
                'utm_medium' => '',
                'utm_term' => '',
                'utm_content' => '',
                'utm_campaign' => '',
            ]);
        }

        // Update the session data
        $sessionData = Session::get('utms');
        $sessionData['utm_source'] = $request->input('utm_source') ?? Cookie::get('utm_source');
        $sessionData['utm_medium'] = $request->input('utm_medium') ?? Cookie::get('utm_medium');
        $sessionData['utm_term'] = $request->input('utm_term') ?? Cookie::get('utm_term');
        $sessionData['utm_content'] = $request->input('utm_content') ?? Cookie::get('utm_content');
        $sessionData['utm_campaign'] = $request->input('utm_campaign') ?? Cookie::get('utm_campaign');
        Session::put('utms', $sessionData);

        $item = Item::where('item_number',$item_number)->first();

        if($item != null){
            $item_info = ItemsInfo::where('item_id', $item->id)->first();
            $images = Image::where('item_id', $item->id)->get();
            $characteristics = Characteristics::where('item_id', $item->id)->get();

            // параметры запроса
            $data = array(
                'key' => getenv('CRM_SECRET_KEY'), //Ваш секретный токен
                'product_id' => $item->item_crm_id // ID товара (45,46,47) можно несколько через запятую
            );

            // запрос
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/getProduct.html');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $out = curl_exec($curl);
            curl_close($curl);
            //$out – ответ сервера в формате JSON

            $response = json_decode($out, true);
            $product_price = '0';
            if ($response && $response['status'] === 'ok') {
                $product_price = $response['data']['price'];
            }

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

    function getAllProducts(){
        $token = '8dbb55c7019da1afa5c9d48fff6e0159'; // Your secret token

        $categoriesData = array(
            'key' => $token,
        );

        // Request categories
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/getCategories.html');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $categoriesData);
        $categoriesResponse = curl_exec($curl);
        curl_close($curl);

        $categories = json_decode($categoriesResponse, true);

        if ($categories && $categories['status'] === 'ok') {
            foreach ($categories['data'] as $category) {
                echo 'Category ID: ' . $category['id'] . '<br>';
                echo 'Category Name: ' . $category['name'] . '<br>';

                $productsData = array(
                    'key' => $token,
                    'category_id' => $category['id']
                );

                // Request products for each category
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/getProductsByCategory.html');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $productsData);
                $productsResponse = curl_exec($curl);
                curl_close($curl);

                $products = json_decode($productsResponse, true);
                if ($products && $products['status'] === 'ok') {
                    foreach ($products['data'] as $product) {
                        echo 'Product ID: ' . $product['id'] . '<br>';
                        echo 'Product Name: ' . $product['name'] . '<br>';
                        // ... access other product properties
                        echo '<br>';
                    }
                } else {
                    echo 'Error retrieving products for category ' . $category['id'] . '<br>';
                }
            }
        } else {
            echo 'Error retrieving categories';
        }
    }




}

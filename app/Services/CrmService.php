<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class CrmService
{

    function getCategories(){
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

    function getProductsByCategory($category_id)
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

    function createOrder($product_id, $product_price, $name, $phone){
        $products_list = array(
            0 => array(
                'product_id' => $product_id,
                'price' => $product_price,
                'count' => '1',
                'subs'       => array(
                    0  => array(
                        'sub_id' => $product_id,
                        'count'  => '1'
                    ))
            )
        );

        $products = urlencode(serialize($products_list));
        $sender = urlencode(serialize($_SERVER));

        $data = [
            'key' => getenv('CRM_SECRET_KEY'), // Your secret token
            'order_id' => number_format(round(microtime(true) * 10), 0, '.', ''),
            'country' => 'UA',
            'office' => '1',
            'products' => $products,
            'bayer_name' => $name,
            'phone' => $phone,
            'payment' => '',
            'sender' => $sender,
            'utm_source' => session('utms.utm_source'),
            'utm_medium' => session('utms.utm_medium'),
            'utm_term' => session('utms.utm_term'),
            'utm_content' => session('utms.utm_content'),
            'utm_campaign' => session('utms.utm_campaign')
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/addNewOrder.html');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);


        if ($out === false) {
            // cURL request failed
            return redirect()->back()->with('error', 'API request failed');
        } else {
            // Assuming the response is in JSON format
            $response = json_decode($out, true);

            // Check the status field in the response
            if (isset($response['status']) && $response['status'] === 'ok') {
                // API request was successful
                return redirect()->back()->with('success', $response['message']);
            } else {
                // API request returned an error
                return redirect()->back()->with('error', $response['message']);
            }
        }
    }

    function getProductById($product_id){
        $data = array(
            'key' => getenv('CRM_SECRET_KEY'),
            'product_id' => $product_id
        );


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/getProduct.html');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);
        //$out – ответ сервера в формате JSON

        $response = json_decode($out, true);

        if ($response && $response['status'] === 'ok') {
            $products = $response['data'];
            return $products;
        }

        return [];
    }
    function Utm()
    {
        $periodCookie = 2592000; // 30 days in seconds

        if (Request::has('utm_source')) {
            $utmSource = Request::input('utm_source');
            Cookie::queue('utm_source', $utmSource, $periodCookie);
        } else {
            $utmSource = Cookie::get('utm_source');
        }

        if (Request::has('utm_medium')) {
            $utmMedium = Request::input('utm_medium');
            Cookie::queue('utm_medium', $utmMedium, $periodCookie);
        } else {
            $utmMedium = Cookie::get('utm_medium');
        }

        if (Request::has('utm_term')) {
            $utmTerm = Request::input('utm_term');
            Cookie::queue('utm_term', $utmTerm, $periodCookie);
        } else {
            $utmTerm = Cookie::get('utm_term');
        }

        if (Request::has('utm_content')) {
            $utmContent = Request::input('utm_content');
            Cookie::queue('utm_content', $utmContent, $periodCookie);
        } else {
            $utmContent = Cookie::get('utm_content');
        }

        if (Request::has('utm_campaign')) {
            $utmCampaign = Request::input('utm_campaign');
            Cookie::queue('utm_campaign', $utmCampaign, $periodCookie);
        } else {
            $utmCampaign = Cookie::get('utm_campaign');
        }

        if (!Session::has('utms')) {
            Session::put('utms', [
                'utm_source' => '',
                'utm_medium' => '',
                'utm_term' => '',
                'utm_content' => '',
                'utm_campaign' => '',
            ]);
        }

        Session::put('utms.utm_source', $utmSource);
        Session::put('utms.utm_medium', $utmMedium);
        Session::put('utms.utm_term', $utmTerm);
        Session::put('utms.utm_content', $utmContent);
        Session::put('utms.utm_campaign', $utmCampaign);
    }
}
